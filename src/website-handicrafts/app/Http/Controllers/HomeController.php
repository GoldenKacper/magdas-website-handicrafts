<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $page = 'home';
        // render home view
        return view('pages.home', compact('page'));
    }
}
