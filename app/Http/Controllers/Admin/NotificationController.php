<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate(10);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Notification::create($request->only('title', 'message'));

        return redirect()->route('admin.notifications.index')
                         ->with('success', 'Notification created successfully.');
    }

    public function edit(Notification $notification)
    {
        return view('admin.notifications.edit', compact('notification'));
    }

    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $notification->update($request->only('title', 'message', 'is_active'));

        return redirect()->route('admin.notifications.index')
                         ->with('success', 'Notification updated successfully.');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->route('admin.notifications.index')
                         ->with('success', 'Notification deleted.');
    }
}
