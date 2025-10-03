<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function index()
    {
        $carousels = Carousel::all();
        return view('admin.carousel.index', compact('carousels'));
    }

    public function create()
    {
        return view('admin.carousel.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'subtitle_two' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'video_link' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('carousels', 'public');
        }

        Carousel::create($data);

        return redirect()->route('admin.carousel.index')->with('success', 'Slide created successfully.');
    }

    public function edit(Carousel $carousel)
    {
        return view('admin.carousel.edit', compact('carousel'));
    }

    public function update(Request $request, Carousel $carousel)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'subtitle_two' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'video_link' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($carousel->image) {
                Storage::disk('public')->delete($carousel->image);
            }
            $data['image'] = $request->file('image')->store('carousels', 'public');
        }

        $carousel->update($data);

        return redirect()->route('admin.carousel.index')->with('success', 'Slide updated successfully.');
    }

    public function destroy(Carousel $carousel)
    {
        if ($carousel->image) {
            Storage::disk('public')->delete($carousel->image);
        }
        $carousel->delete();
        return redirect()->route('admin.carousel.index')->with('success', 'Slide deleted successfully.');
    }
}
