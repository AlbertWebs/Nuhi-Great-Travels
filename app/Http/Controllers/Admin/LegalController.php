<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Legal;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function index()
    {
        $legals = Legal::all();
        return view('admin.legals.index', compact('legals'));
    }

    public function edit($page)
    {
        $legal = Legal::where('page', $page)->firstOrFail();
        return view('admin.legals.edit', compact('legal'));
    }

    public function update(Request $request, $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $legal = Legal::where('page', $page)->firstOrFail();
        $legal->update($request->only('title', 'content'));

        return redirect()->route('admin.legals.index')->with('success', ucfirst($page).' page updated successfully!');
    }
}
