<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the application Contact Page.
     */
    public function index()
    {
        $page = 'contact';
        // render contact view
        return view('pages.contact', compact('page'));
    }
}
