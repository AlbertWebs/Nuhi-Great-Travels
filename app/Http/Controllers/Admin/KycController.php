<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KycSubmission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Setting;
use App\Models\SmileIdVerification;
use Illuminate\Support\Facades\Log;

use Auth;

class KycController extends Controller
{
    /**
     * Display a list of all KYC submissions.
     */
    public function index()
    {
        $kycs = KycSubmission::latest()->paginate(10);
        return view('admin.kyc.index', compact('kycs'));
    }

    /**
     * Show the KYC submission form.
     */
    public function create()
    {
        return view('admin.kyc.create');
    }

    /**
     * Store a new KYC submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'document_type' => 'required|string',
            'document_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'selfie_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'liveliness_data' => 'nullable|string',
        ]);

        $documentPath = $request->file('document_image')->store('kyc/documents', 'public');
        $selfiePath = $request->file('selfie_image')->store('kyc/selfies', 'public');

        KycSubmission::create([
            'name' => $request->name,
            'document_type' => $request->document_type,
            'document_image' => $documentPath,
            'selfie_image' => $selfiePath,
            'liveliness_data' => $request->liveliness_data,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.kyc.index')->with('success', 'KYC submission saved successfully.');
    }

    /**
     * View single KYC record.
     */
    public function show(KycSubmission $kyc)
    {
        return view('admin.kyc.show', compact('kyc'));
    }

    /**
     * Update the KYC status (approve/reject).
     */
    public function updateStatus(Request $request, KycSubmission $kyc)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $kyc->update(['status' => $request->status]);

        return back()->with('success', 'KYC status updated.');
    }

    public function uploadLiveliness(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|string',
                'instruction' => 'required|string',
            ]);

            $imageData = str_replace('data:image/png;base64,', '', $request->image);
            $imageData = str_replace(' ', '+', $imageData);
            $imageName = 'kyc/selfies/' . uniqid() . '.png';

            Storage::disk('public')->put($imageName, base64_decode($imageData));

            return response()->json([
                'success' => true,
                'image_path' => asset('storage/' . $imageName),
                'details' => [
                    'timestamp' => now()->toDateTimeString(),
                    'instruction_followed' => $request->instruction,
                    'detection_confidence' => $request->input('details.detection_confidence'),
                    'expressions' => $request->input('details.expressions'),
                ]
            ]);
        } catch (\Throwable $th) {
            \Log::error('Liveliness Upload Error: ' . $th->getMessage());
            return response()->json(['success' => false, 'message' => 'Upload failed', 'error' => $th->getMessage()], 500);
        }
    }


    public function showPublicForm($token)
    {
        $Settings = Setting::first();
        $client = Auth::User();
        return view('kyc.public', compact('client','Settings'));
    }

public function storePublic(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'document_type' => 'required|string',
        'document_image' => 'required|image|max:2048',
        'liveliness_data' => 'required|string',
        'selfie_image' => 'required|string'
    ]);

    $documentPath = $request->file('document_image')->store('kyc_documents', 'public');

    \App\Models\Kyc::create([
        'client_id' => $request->input('client_id'),
        'name' => $validated['name'],
        'document_type' => $validated['document_type'],
        'document_image' => $documentPath,
        'liveliness_data' => $validated['liveliness_data'],
        'selfie_image' => $validated['selfie_image'],
    ]);

    return redirect()->route('kyc.thankyou');
}

public function generateKYCToken(){
    $client->update(['kyc_token' => Str::uuid()]);
}

public function smileIdCallback(Request $request)
{
    $payload = $request->all();
    Log::info('Smile ID Callback received', $payload);

    $jobId = $payload['job_id'] ?? null;
    $partnerParams = $payload['partner_params'] ?? [];
    $userId = $partnerParams['user_id'] ?? null;

    // Save or update verification
    $verification = SmileIdVerification::updateOrCreate(
        ['job_id' => $jobId],
        [
            'user_id' => $userId,
            'job_type' => $partnerParams['job_type'] ?? null,
            'result_code' => $payload['result_code'] ?? null,
            'result_text' => $payload['result_text'] ?? null,
            'partner_params' => $partnerParams,
            'actions' => $payload['actions'] ?? null,
            'images' => $payload['images'] ?? null,
            'raw_response' => $payload,
            'completed_at' => now(),
        ]
    );

    // Optionally, mark user as KYC-verified
    if ($verification->result_code === '0' && $userId) {
        $user = \App\Models\User::find($userId);
        if ($user) {
            $user->update(['kyc_verified' => true]);
        }
    }

    return response()->json(['status' => 'received']);
}

}
