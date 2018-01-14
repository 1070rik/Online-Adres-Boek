<?php

namespace AdresBoek\Http\Controllers;

use Illuminate\Http\Request;
use AdresBoek\contacts;
use AdresBoek\addresses;
use AdresBoek\User;
use AdresBoek\requests;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

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
          $contacts = contacts::get();
          return view('admin.getAllContacts', compact('contacts'));
    }

    public function getAllUsers(request $request)
    {
          $users = User::get();
          return  view('admin.getAllUsers', compact('users'));
    }

    public function getAllRequests(Request $request)
    {
          $requests = requests::get();
          return  view('admin.getAllRequests', compact('requests'));
    }
}
