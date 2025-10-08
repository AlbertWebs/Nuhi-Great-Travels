<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Fleet;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $page_title = "Home";
        $carousels = \App\Models\Carousel::all();
        $Settings = \App\Models\Setting::first();
        $feedbacks = \App\Models\Feedback::latest()->take(10)->get();
        $About = \App\Models\About::first();
        $faqs = \App\Models\Faq::where('is_active', true)->get();
        $blogs = \App\Models\Blog::latest()->take(6)->get();
        return view('frontend.home', compact('carousels', 'Settings','About','faqs','feedbacks','blogs','page_title'));
    }

    public function about()
    {
        $blogs = \App\Models\Blog::latest()->take(6)->get();
        $clients = \App\Models\Client::all();
        $page_title = "About Us";
        $About = \App\Models\About::first();
        $Settings = \App\Models\Setting::first();
        $feedbacks = \App\Models\Feedback::latest()->take(10)->get();
        return view('frontend.about', compact('About','feedbacks','page_title','Settings','blogs','clients'));
    }

     public function contact()
        {
            $page_title = "Contact Us";
            $About = \App\Models\About::first();
            // $teams = \App\Models\Team::where('is_active', true)->get();
            $Settings = \App\Models\Setting::first();
            $feedbacks = \App\Models\Feedback::latest()->take(10)->get();
            return view('frontend.contact', compact('About', 'feedbacks','Settings','page_title'));
        }

    public function updates()
    {
        $blogs = \App\Models\Blog::latest()->paginate(12);
        $page_title = "Contact Us";
        $About = \App\Models\About::first();
        // $teams = \App\Models\Team::where('is_active', true)->get();
        $Settings = \App\Models\Setting::first();
        $feedbacks = \App\Models\Feedback::latest()->take(10)->get();
        return view('frontend.updates', compact('blogs', 'feedbacks','Settings','page_title'));
    }

    public function show($slug){
        $blogs = \App\Models\Blog::where('slug', $slug)->first();
        $page_title = "Contact Us";
        $About = \App\Models\About::first();
        // $teams = \App\Models\Team::where('is_active', true)->get();
        $Settings = \App\Models\Setting::first();
        $feedbacks = \App\Models\Feedback::latest()->take(10)->get();
        return view('frontend.update', compact('blogs', 'feedbacks','Settings','page_title'));
    }

    public function show_fleet($slug){
        $car = \App\Models\Car::where('slug', $slug)->first();
        $Fleet = \App\Models\Fleet::where('car_id', $car->id)->get();
        $page_title = "Fleet";
        $About = \App\Models\About::first();
        // $teams = \App\Models\Team::where('is_active', true)->get();
        $Settings = \App\Models\Setting::first();
        $feedbacks = \App\Models\Feedback::latest()->take(10)->get();
        return view('frontend.show_fleet', compact('feedbacks','Settings','page_title','car','Fleet'));
    }


    public function services_single($slug){
        $page_title = "Services";
        $Services = \App\Models\Service::where('slug' ,$slug)->first();
        $Settings = \App\Models\Setting::first();
        $feedbacks = \App\Models\Feedback::latest()->take(10)->get();
        return view('frontend.services_single', compact('feedbacks','Settings','page_title','Services'));
    }

    public function show_single_fleets($car,$slug){
        $car = \App\Models\Car::where('slug', $slug)->first();
        $Fleet = \App\Models\Fleet::where('slug', $slug)->first();

        $page_title = "Fleet";
        $About = \App\Models\About::first();
        // $teams = \App\Models\Team::where('is_active', true)->get();
        $Settings = \App\Models\Setting::first();
        $feedbacks = \App\Models\Feedback::latest()->take(10)->get();
        return view('frontend.show_single_fleets', compact('feedbacks','Settings','page_title','car','Fleet'));
    }



    public function generateSlugs()
    {
        $fleets = Fleet::whereNull('slug')->orWhere('slug', '')->get();

        foreach ($fleets as $fleet) {
            $fleet->slug = Str::slug($fleet->name . '-' . $fleet->id);
            $fleet->save();
        }

        return redirect()->back()->with('success', 'Fleet slugs generated successfully.');
    }

    public function contactFormSubmit(Request $request)
    {
        // 1. Validate the incoming data
        // NOTE: This server-side validation is CRITICAL for security
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'number'  => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // 2. Prepare and Send the Email
        try {
            // Using the Mail facade to send a simple email (adjust as needed for a custom Mailable)
            Mail::raw("New Contact Form Submission:\n\n" .
                      "Name: " . $validated['name'] . "\n" .
                      "Email: " . $validated['email'] . "\n" .
                      "Mobile: " . $validated['number'] . "\n" .
                      "Company: " . ($validated['company'] ?? 'N/A') . "\n" .
                      "Message: " . $validated['message'],
                function ($message) use ($validated) {
                    $message->to('admin@nuhigreattravels.com')
                    ->cc('albertmuhatia@gmail.com')->subject('New Contact Inquiry from ' . $validated['name'])
                            ->from($validated['email'], $validated['name']);
            });

            // 3. Return a successful JSON response
            return response()->json([
                'status'  => 'success',
                'message' => 'Your message has been sent successfully!'
            ]);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Contact form submission failed: ' . $e->getMessage());

            // 4. Return an error JSON response
            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry, there was an issue sending your message. Please try again later.'
            ], 500); // HTTP 500 status for server error
        }
    }

}
