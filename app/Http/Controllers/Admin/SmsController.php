<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function index()
    {
        $messages = Sms::latest()->paginate(10);
        return view('admin.sms.index', compact('messages'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.sms.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'message' => 'required|string',
            'recipients' => 'required|array',
        ]);

        // Simulate sending SMS here (or integrate API)
        Sms::create([
            'message' => $data['message'],
            'recipients' => $data['recipients'],
            'status' => 'sent'
        ]);

        return redirect()->route('admin.sms.index')->with('success', 'SMS sent successfully!');
    }

    public function show(Sms $sm)
    {
        $users = \App\Models\User::whereIn('id', $sm->recipients)->get();
        return view('admin.sms.show', compact('sm', 'users'));
    }
}
