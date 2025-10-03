<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show settings form.
     */
    public function index()
    {
        $setting = Setting::first(); // fetch first row
        return view('admin.settings.index', compact('setting'));
    }

    /**
     * Store or update settings.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'nullable|url',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'favicon' => 'nullable|image|mimes:png,ico,jpg|max:512',
            'shape' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'mobile' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'tawkto' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'twitter' => 'nullable|url',
            'youtube' => 'nullable|url',
            'map_iframe' => 'nullable|string',
        ]);

        $setting = Setting::firstOrNew(['id' => 1]);

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $setting->logo = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            $setting->favicon = $request->file('favicon')->store('settings', 'public');
        }

        // Save other fields
        $setting->fill($request->except(['logo', 'favicon']));
        $setting->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
