<?php

namespace AdresBoek\Http\Controllers;

use AdresBoek\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    protected function create(Request $request){
        $password = str_random(15);

        $user = new User();
        $user->email = $request['email'];
        $user->password = bcrypt($password);
        $user->admin = $request['admin'];
        $user->save();

        // TODO: send password to email ($request['email'])
    }

    protected function getAll(Request $request){
        $users = User::get();
        return  view('getAllUsers', compact('users'));
    }

    protected function edit(Request $request){
        User::where('id', $request['id'])->update([ 'email' => $request['email'],
                                                    'admin' => $request['admin']]);

        return redirect('getAllUsers');
    }

    public function createUser()
    {
        return view('createUser');
    }
}
