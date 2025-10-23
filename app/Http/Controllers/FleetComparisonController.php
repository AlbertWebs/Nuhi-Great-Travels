<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fleet;

class FleetComparisonController extends Controller
{
    // Show form to select two cars
    public function showCompareForm()
    {
        $page_title = "fleet";
        $fleets = Fleet::all(); // Get all fleets for selection
        return view('fleets.compare-form', compact('fleets','page_title'));
    }

    // Show comparison result of two selected cars
    public function compare(Request $request)
    {
         $page_title = "fleet";
        $request->validate([
            'fleetA_id' => 'required|exists:fleets,id|different:fleetB_id',
            'fleetB_id' => 'required|exists:fleets,id|different:fleetA_id',
        ]);

        $fleetA = Fleet::with('images')->findOrFail($request->input('fleetA_id'));
        $fleetB = Fleet::with('images')->findOrFail($request->input('fleetB_id'));

        return view('fleets.compare', compact('fleetA', 'fleetB','page_title'));
    }
}
