<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Show the application About me Page.
     */
    public function index()
    {
        $page = 'about';
        // render about view
        return view('pages.about', compact('page'));
    }
}
