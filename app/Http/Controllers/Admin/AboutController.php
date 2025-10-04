<?php

namespace App\Http\Controllers\Admin;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    // Show About page (frontend)
    public function index()
    {
        $about = About::first();
        return view('admin.about.edit', compact('about'));
    }

    // Admin edit form
    public function edit()
    {
        $about = About::first();
        return view('admin.about.edit', compact('about'));
    }

  public function update(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'mission' => 'required',
            'vision' => 'required',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $about = About::firstOrCreate([]);

        if ($request->hasFile('featured_image')) {
            if ($about->featured_image) {
                Storage::disk('public')->delete($about->featured_image);
            }

            $path = $request->file('featured_image')->store('abouts', 'public');
            $about->featured_image = $path;
        }

        $about->description = $request->description;
        $about->mission = $request->mission;
        $about->vision = $request->vision;
        $about->save();
        return redirect()->back()->with('success', 'About page updated successfully.');
    }


}
