<?php
namespace AdresBoek\Http\Controllers;

use AdresBoek\Mail\passwordMail;
use AdresBoek\Mail\userMail;
use AdresBoek\Mail\resetMail;
use AdresBoek\password_resets;
use AdresBoek\requests;
use AdresBoek\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class userController extends Controller
{

    protected function create(Request $request)
    {
        //Get all users with the same email as has been entered
        $users = User::where('email', $request['email'])->get();
        if (count($users) > 0) {
            //Return back if there already is an account registered
            return redirect('getAllUsers')->with(['error' => 'Email is already registered!']);
        } else {
            //Else, create an account and send an email to the user.
            $password       = str_random(15);
            $user           = new User();
            $user->uniqid   = uniqid();
            $user->email    = $request['email'];
            $user->password = bcrypt($password);
            $user->admin    = $request['admin'];
            $user->save();
            $mailData = ['email' => $request['email'], 'password' => $password];
            Mail::to($request['email'])->send(new passwordMail($mailData));
            return redirect('admin/users');
        }
    }

    protected function getAll(Request $request)
    {
        //Get all users and serve them to the view
        $users = User::get();
        return view('admin.getAllUsers', compact('users'));
    }

    protected function edit(Request $request)
    {
        //Check which button has been clicked
        if ($request['submit'] == "change") {
            //Update the field.
            User::where('id', $request['id'])->update(['email' => $request['email'], 'admin' => $request['admin']]);
        } else {
            //Remove the field.
            User::where('id', $request['id'])->delete();
        }
        //Redirect to the page withh all users.
        return redirect('admin/users');
    }

    protected function delete(Request $request)
    {
        //Delete a user.
        User::where('id', $request['id'])->delete();
        return redirect('admin/users');
    }

    public function createUser()
    {
        //Controller function to serve a backup view to create users.
        return view('users.createUser', compact('users'));
    }

    public function loggedIn(Request $request)
    {
        //Check if it is the users first visit. If so, make the user change his password. (Only if the user was created by the admin himself and didn't request an account)
        if (Auth::user()->firstVisit == 1) {
            return redirect('user/resetPassword');
        } else {
            return redirect('/home');
        }
    }

    public function resetPass()
    {
        //Check if the user has reset his password before
        if (Auth::user()->firstVisit != 1) {
            //Return to the home view.
            return redirect('/home');
        } else {
            //return the edit password view.
            return view('users.resetFirstPassword');
        }
    }

    public function requestUser(Request $request)
    {
        //Serve the view to request an account.
        return view('users.requestUser');
    }

    public function requestUserPost(Request $request)
    {
        //Put the posted email in a variable (for ease of use)
        $email = $request->email;
        //Check if email belongs to a registered user.
        if (User::where('email', $email)->exists()) {
            //Return to the request page with a message.
            return redirect('requestUser')->with(['message-negative' => 'User already registered']);
            //Check if email belongs to a previous request
        } else if (requests::where('email', $email)->exists()) {
            //Return to the request page with a message.
            return redirect('requestUser')->with(['message-negative' => 'User already waiting for approval']);
        } else {
            //Add email to the request table
            requests::create([
                'email' => $email,
            ]);
            //Return to the request page with a success message.
            return redirect('requestUser')->with(['message-positive' => 'Request for an account has been made']);
        }

    }

    public function editRequestPost(Request $request)
    {
        //Check which button has been clicked
        if ($request['submit'] == "approve") {
            //Generate random password
            $password = str_random(15);
            //Create new user with the info provided by the table record
            User::create([
                'uniqid'     => uniqid(),
                'email'      => $request['email'],
                'password'   => bcrypt($password),
                'admin'      => 0,
                'firstVisit' => 0,
            ]);
            //Put all the information in an array to be mailed.
            $mailData = ['email' => $request['email'], 'password' => $password];
            //Send email to the user.
            Mail::to($request['email'])->send(new userMail($mailData));
            //Delete the request
            requests::where('id', $request['id'])->delete();
            //Return with a message
            return redirect('getAllRequests')->with(['message-positive' => 'Request was granted. Account has been made and user has been informed.']);
        } else {
            //Delete the request
            requests::where('id', $request['id'])->delete();
            //Retuen with a message
            return redirect('getAllRequests')->with(['message-positive' => 'Request was denied. Request has been denied.']);
        }
    }

    public function resetFirstPassPost(Request $request)
    {
        //Check if user has user reset his password before
        if (Auth::user()->firstVisit != 1) {
            //Return with error message
            return redirect('/home')->with(['message_negative' => 'You can\'t access this route anymore']);
        } else {
            //Check if uniqids check uo
            if ($request['uniqid'] == Auth::user()->uniqid) {
                //Update user
                User::where('uniqid', $request['uniqid'])->update(['password' => bcrypt($request['password_new']), 'firstVisit' => 0]);
                //Redirect with message
                return redirect('/home')->with(['message_positive' => 'Password succesfully changed!']);
            }
        }
    }

    public function requestPasswordPost(Request $request)
    {
        $email = $request->email;
        $token = str_random(30);

        if (User::where('email', $email)->exists()) {
            //User exists. send email
            if(password_resets::where('email', $email)->exists()) {
                password_resets::where('email', $email)->delete();
            }
            password_resets::create([
                'email' => $email,
                'token' => $token,
            ]);

            //Send email
            $mailData = ['email' => $email, 'token' => $token];
            //Send email to the user.
            Mail::to($request['email'])->send(new resetMail($mailData));

            return redirect('/password/reset')->with(['message-positive' => 'Password reset link has been sent.']);
        } else {
            //User doesn't exist
            return redirect('/password/reset')->with(['message-negative' => 'User doesn\'t exist.']);
        }
    }

    public function getPasswordReset($token, Request $request)
    {
        $token = $request->token;
        return view('auth.passwords.reset', compact('token'));
    }

    public function passwordResetPost(Request $request)
    {
        $token = $request->reset_token;
        if (password_resets::where('token', $token)->exists()) {
            $password_row = password_resets::where('token', $token)->first();
            if ($password_row->token != $token) {
                return redirect('/password/get_reset/' . $token)->with(['message-negative' => 'Reset token doesn\'t match the one in the database.']);
            } else {
                if ($password_row->email != $request->email) {
                    return redirect('/password/get_reset/' . $token)->with(['message-negative' => 'Email doesn\'t match the one the token has registered in the database.']);
                } else {
                    if ($request->password != $request->password_repeat) {
                        return redirect('/password/get_reset/' . $token)->with(['message-negative' => 'Passwords don\'t match']);
                    } else {
                        if (strlen($request->password) < 5) {
                            return redirect('/password/get_reset/' . $token)->with(['message-negative' => 'Passwords have to be atleast 5 characters']);
                        } else {
                            User::where('email', $request['email'])->update([
                                'password' => bcrypt($request['password']),
                            ]);
                            password_resets::where('token', $token)->delete();
                            return redirect('/login')->with(['message-positive' => 'Password has been reset.']);
                        }
                    }
                }
            }
        } else {
            return redirect('/login')->with(['message-negative' => 'Reset token doesn\'t exist.']);
        }
    }
}
