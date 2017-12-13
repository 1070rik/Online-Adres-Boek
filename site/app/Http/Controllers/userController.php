<?php

namespace AdresBoek\Http\Controllers;

use AdresBoek\User;
use AdresBoek\Mail\passwordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
    protected function create(Request $request){

        $users = User::where('email', $request['email']);

        if (count($users) > 0){
            return redirect('getAllUsers')->with([
                'error' => 'Email is already registered!'
            ]);
        } else {
            $password = str_random(15);

            $user = new User();
            $user->uniqid = uniqid();
            $user->email = $request['email'];
            $user->password = bcrypt($password);
            $user->admin = $request['admin'];
            $user->save();

            $mailData = [
              'email' => $request['email'],
              'password' => $password
            ];

            Mail::to($request['email'])->send(new passwordMail($mailData));

            return redirect('getAllUsers');
        }
    }

    protected function getAll(Request $request){
        $users = User::get();
        return  view('users.getAllUsers', compact('users'));
    }

    protected function edit(Request $request){

        if($request['submit'] == "change"){
            User::where('id', $request['id'])->update([ 'email' => $request['email'],
                                                        'admin' => $request['admin']]);
        }
        else{
            User::where('id', $request['id'])->delete();
        }

        return redirect('getAllUsers');
    }

    protected function delete(Request $request){
        User::where('id', $request['id'])->delete();

        return redirect('getAllUsers');
    }

    public function createUser()
    {
        return view('users.createUser', compact('users'));
    }

    public function loggedIn(Request $request)
    {
      if (Auth::user()->firstVisit == 1) {
        return redirect('user/resetPassword');
      }else{
        return redirect('/home');
      }
    }

    public function resetPass()
    {
      if(Auth::user()->firstVisit != 1){
        return redirect('/home');
      }else{
        return view('users.resetFirstPassword');
      }

    }

    public function resetFirstPassPost(Request $request)
    {
      if(Auth::user()->firstVisit != 1){
        return redirect('/home')->with([
          'message_negative' => 'You can\'t access this route anymore'
        ]);
      }else{
        if($request['uniqid'] == Auth::user()->uniqid){
          User::where('uniqid', $request['uniqid'])->update([
            'password' => bcrypt($request['password_new']),
            'firstVisit' => 0
          ]);
          return redirect('/home')->with([
            'message_positive' => 'Password succesfully changed!'
          ]);
        }
      }
    }
}
