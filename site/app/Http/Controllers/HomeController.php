<?php

namespace AdresBoek\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Serve home view
        return view('search.maps');
    }
}
