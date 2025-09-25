<?php

namespace App\Http\Controllers;

use App\Models\AboutMe;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Show the application About me Page.
     */
    public function index()
    {
        $aboutMe = AboutMe::withLocalized()->first();

        $page = 'about';
        // render about view
        return view('pages.about', compact('page', 'aboutMe'));
    }
}
