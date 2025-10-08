<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class SubscriberController extends Controller
{
    // Show About page (frontend)
    public function index()
    {
        $subscribers = Subscriber::paginate();
        return view('admin.subscribers.index', compact('subscribers'));
    }






}
