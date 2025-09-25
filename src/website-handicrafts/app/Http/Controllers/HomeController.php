<?php

namespace App\Http\Controllers;

use App\Models\AboutMe;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Opinion;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application Home Page.
     */
    public function index()
    {
        $categories = Category::forFrontend()->get();
        $aboutMe = AboutMe::withLocalized()->whereHas('translations', function ($query) {
            $query->where('locale', app()->getLocale())
                ->where('main_page', true);
        })->first();
        $opinions = Opinion::forFrontend()->get();
        $faqs = Faq::forFrontend()->take(4)->get();

        $page = 'home';
        // render home view
        return view('pages.home', compact('page', 'categories', 'aboutMe', 'opinions', 'faqs'));
    }
}
