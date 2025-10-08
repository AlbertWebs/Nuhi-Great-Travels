<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Models\Subscriber;

class SubscriberPostController extends Controller
{



public function ajaxStore(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:subscribers,email'
    ]);

    // Save to database
    $subscriber = Subscriber::create([
        'email' => $request->email,
        'is_active' => true
    ]);

    // Add to Mailchimp
    try {
        $apiKey = config('services.mailchimp.key'); // store in config/services.php
        $listId = config('services.mailchimp.list_id');

        $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);

        $response = Http::withBasicAuth('anystring', $apiKey)
            ->post("https://{$dataCenter}.api.mailchimp.com/3.0/lists/{$listId}/members", [
                'email_address' => $request->email,
                'status' => 'subscribed',
            ]);

        if (!$response->successful()) {
            // Optional: log or notify failure to sync with Mailchimp
        }
    } catch (\Exception $e) {
        // Optional: log exception
    }

    return response()->json(['message' => 'Thank you for subscribing!']);
}



}
