<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fleet;
use App\Models\Car;

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
            'name' => 'required|string|max:255',
            'car_id' => 'required|exists:cars,id',
            'price' => 'nullable|numeric',
            'type' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('fleets', 'public');
        }

        Fleet::create($data);
        return redirect()->route('admin.fleets.index')->with('success', 'Fleet added successfully.');
    }

    public function edit(Fleet $fleet)
    {
        $cars = Car::all();
        return view('admin.fleets.edit', compact('fleet', 'cars'));
    }

    public function update(Request $request, Fleet $fleet)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'car_id' => 'required|exists:cars,id',
            'price' => 'nullable|numeric',
            'type' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('fleets', 'public');
        }

        $fleet->update($data);
        return redirect()->route('admin.fleets.index')->with('success', 'Fleet updated successfully.');
    }

    public function destroy(Fleet $fleet)
    {
        if ($fleet->image && file_exists(storage_path('app/public/'.$fleet->image))) {
            unlink(storage_path('app/public/'.$fleet->image));
        }

        $fleet->delete();
        return redirect()->route('admin.fleets.index')->with('success', 'Fleet deleted successfully.');
    }
}
