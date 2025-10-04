<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $carousels = \App\Models\Carousel::all();
        $Settings = \App\Models\Setting::first();
        $About = \App\Models\About::first();
        $faqs = \App\Models\Faq::where('is_active', true)->get();
        return view('frontend.home', compact('carousels', 'Settings','About','faqs'));
    }
}
