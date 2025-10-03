<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $carousels = \App\Models\Carousel::all();
        return view('frontend.home', compact('carousels'));
    }
}
