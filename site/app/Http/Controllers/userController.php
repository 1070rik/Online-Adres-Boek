<?php

namespace AdresBoek\Http\Controllers;

use AdresBoek\User;
use AdresBoek\Mail\passwordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class userController extends Controller
{
    protected function create(Request $request){
        $password = str_random(15);

        $user = new User();
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

    protected function getAll(Request $request){
        $users = User::get();
        return  view('getAllUsers', compact('users'));
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
        return view('createUser', compact('users'));
    }
}
