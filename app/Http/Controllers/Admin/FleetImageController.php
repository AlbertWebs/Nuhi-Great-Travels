<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\FleetImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FleetImageController extends Controller
{
    /**
     * Show the gallery management page for a fleet.
     */
    public function index(Fleet $fleet)
    {
        return view('admin.fleets.images', compact('fleet'));
    }

    /**
     * Store uploaded images for a fleet.
     */
    public function store(Request $request, Fleet $fleet)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('fleets', 'public');

                $fleet->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()
            ->route('admin.fleets.images', $fleet->id)
            ->with('success', 'Images uploaded successfully!');
    }

    /**
     * Delete an image from a fleet.
     */
    public function destroy(Fleet $fleet, FleetImage $image)
    {
        // Ensure the image belongs to this fleet
        if ($image->fleet_id !== $fleet->id) {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return redirect()
            ->back()
            ->with('success', 'Image deleted successfully!');
    }
}
