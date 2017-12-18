<?php

namespace AdresBoek\Http\Controllers;

use Illuminate\Http\Request;
use AdresBoek\contacts;
use AdresBoek\addresses;
use AdresBoek\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    public function index()
    {
      Artisan::call('stats');
      $output = Artisan::output();
      return view('admin.index', compact('output'));
    }

    public function insertTestData($value='')
    {

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
}
