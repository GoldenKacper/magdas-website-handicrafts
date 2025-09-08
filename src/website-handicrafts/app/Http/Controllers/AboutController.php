<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $page = 'about';
        // render about view
        return view('pages.about', compact('page'));
    }
}
