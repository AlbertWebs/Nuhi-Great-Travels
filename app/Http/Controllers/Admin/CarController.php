<?php

namespace App\Http\Controllers\Admin;

use App\Models\Car;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::latest()->paginate(10);
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'make' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Generate slug from make
        $data['slug'] = Str::slug($data['make']);

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $count = 1;
        while (Car::where('slug', $data['slug'])->exists()) {
            $data['slug'] = "{$originalSlug}-{$count}";
            $count++;
        }

        Car::create($data);

        return redirect()->route('admin.cars.index')->with('success', 'Car added successfully.');
    }

    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $data = $request->validate([
            'make' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Regenerate slug if make changed
        if ($car->make !== $data['make']) {
            $data['slug'] = Str::slug($data['make']);
            $originalSlug = $data['slug'];
            $count = 1;
            while (Car::where('slug', $data['slug'])->where('id', '!=', $car->id)->exists()) {
                $data['slug'] = "{$originalSlug}-{$count}";
                $count++;
            }
        } else {
            $data['slug'] = $car->slug;
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully.');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('admin.cars.index')->with('success', 'Car deleted successfully.');
    }
}
