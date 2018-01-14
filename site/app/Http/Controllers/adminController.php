<?php

namespace AdresBoek\Http\Controllers;

use AdresBoek\contacts;
use AdresBoek\requests;
use AdresBoek\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class adminController extends Controller
{
    public function index()
    {
        //Get all the stats
        Artisan::call('stats');
        $output = Artisan::output();
        //Serve admin index with the stats
        return view('admin.index', compact('output'));
    }

    public function getAllContacts(Request $request)
    {
        //Get all contacts and serve them to the view
        $contacts = contacts::get();
        return view('admin.getAllContacts', compact('contacts'));
    }

    public function getAllUsers(request $request)
    {
        //Get all users and serve them to the view
        $users = User::get();
        return view('admin.getAllUsers', compact('users'));
    }

    public function getAllRequests(Request $request)
    {
        //Get all requests and serve them to the view
        $requests = requests::get();
        return view('admin.getAllRequests', compact('requests'));
    }
}
