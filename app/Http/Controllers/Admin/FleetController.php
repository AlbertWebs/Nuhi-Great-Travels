<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fleet;
use App\Models\Car;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class FleetController extends Controller
{
    public function index()
    {
        $fleets = Fleet::latest()->paginate(10);
        return view('admin.fleets.index', compact('fleets'));
    }

    public function create()
    {
        $cars = Car::all();
        return view('admin.fleets.create', compact('cars'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'transmission' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'seats' => 'nullable|integer',
            'year' => 'nullable|integer',
            'price_per_day' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'status' => 'nullable|string|max:50',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Generate unique slug
        $baseSlug = Str::slug($data['name']);
        $count = Fleet::where('slug', 'like', "{$baseSlug}%")->count();
        $data['slug'] = $count ? "{$baseSlug}-{$count}" : $baseSlug;

        // Default status
        $data['status'] = $data['status'] ?? 'available';

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('fleets', 'public');
        }

        Fleet::create($data);

        return redirect()->route('admin.fleets.index')
            ->with('success', 'Fleet added successfully.');
    }

    public function edit(Fleet $fleet)
    {
        $cars = Car::all();
        return view('admin.fleets.edit', compact('fleet', 'cars'));
    }

    public function update(Request $request, Fleet $fleet)
    {
        $data = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'transmission' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'seats' => 'nullable|integer',
            'year' => 'nullable|integer',
            'price_per_day' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'status' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Regenerate slug if name changed
        $data['slug'] = Str::slug($data['name'], '-');

        // Handle image replacement
        if ($request->hasFile('image')) {
            if ($fleet->image && Storage::disk('public')->exists($fleet->image)) {
                Storage::disk('public')->delete($fleet->image);
            }
            $data['image'] = $request->file('image')->store('fleets', 'public');
        }

        $fleet->update($data);

        return redirect()->route('admin.fleets.index')->with('success', 'Fleet updated successfully.');
    }

    public function destroy(Fleet $fleet)
    {
        if ($fleet->image && Storage::disk('public')->exists($fleet->image)) {
            Storage::disk('public')->delete($fleet->image);
        }

        $fleet->delete();

        return redirect()->route('admin.fleets.index')->with('success', 'Fleet deleted successfully.');
    }
}
