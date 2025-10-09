<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KycSubmission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Setting;
use Auth;

use Illuminate\Support\Facades\Log;
use App\Models\Kyc;
use App\Models\Booking;
use App\Models\Car;
use App\Models\User;

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
            'image_path' => $imageName,
            'details' => [
                'timestamp' => now()->toDateTimeString(),
                'instruction_followed' => $request->instruction,
                'detection_confidence' => $request->input('details.detection_confidence'),
                'expressions' => $request->input('details.expressions'),
            ]
        ]);
    }

    public function showPublicForm($token)
    {
        $Settings = Setting::first();
        $client = Auth::User();
        return view('kyc.public', compact('client','Settings'));
    }

public function storePublic(Request $request)
{
    try {
        Log::info('KYC submission started', ['client_id' => $request->input('client_id')]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'document_type' => 'required|string',
            'document_image' => 'required|image|max:2048',
            'liveliness_data' => 'required|string',
            'selfie_image' => 'required|string',
        ]);

        // 1️⃣ Upload document image
        $documentPath = $request->file('document_image')->store('kyc_documents', 'public');
        Log::info('Document uploaded successfully', ['path' => $documentPath]);

        // 2️⃣ Save KYC record
        $kyc = Kyc::create([
            'client_id' => $request->input('client_id'),
            'name' => $validated['name'],
            'document_type' => $validated['document_type'],
            'document_image' => $documentPath,
            'liveliness_data' => $validated['liveliness_data'],
            'selfie_image' => $validated['selfie_image'],
        ]);
        Log::info('KYC record created successfully', ['kyc_id' => $kyc->id]);

        // 3️⃣ Retrieve booking session data
        $step1 = session('booking.step1');
        $step2 = session('booking.step2');
        $totalPrice = session('booking.total_price');

        if (!$step1 || !$step2) {
            Log::warning('Booking session data missing', [
                'step1' => $step1,
                'step2' => $step2,
            ]);
        } else {
            $car = Car::find($step1['car_id']);
            if (!$car) {
                Log::error('Car not found for booking', ['car_id' => $step1['car_id']]);
                throw new \Exception('Invalid car selection.');
            }

            $booking = Booking::create([
                'car_id' => $car->id,
                'user_id' => Auth::id() ?? $request->input('client_id'),
                'pickup_datetime' => $step1['pickup_datetime'],
                'dropoff_datetime' => $step1['dropoff_datetime'],
                'pickup_location' => $step1['pickup_location'],
                'dropoff_location' => $step1['dropoff_location'] ?? null,
                'status' => 'confirmed',
                'total_price' => $totalPrice,
                'notes' => 'KYC verified booking for ' . $validated['name'],
            ]);

            Log::info('Booking created successfully', ['booking_id' => $booking->id]);

            // 4️⃣ Update KYC token for client
            $client = User::find($request->input('client_id'));
            if ($client) {
                $client->update(['kyc_token' => Str::uuid()]);
                Log::info('KYC token updated for user', ['user_id' => $client->id]);
            } else {
                Log::warning('Client not found for KYC update', ['client_id' => $request->input('client_id')]);
            }

            // 5️⃣ Clear booking session data
            session()->forget(['booking.step1', 'booking.step2', 'booking.total_price']);
        }

        // 6️⃣ Success redirect
        Log::info('KYC + Booking flow completed successfully', [
            'client_id' => $request->input('client_id'),
        ]);

        return redirect()->route('kyc.thankyou')->with('success', 'KYC and booking submitted successfully!');

    } catch (\Throwable $e) {
        // 7️⃣ Catch and log errors
        Log::error('Error during KYC + Booking submission', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return back()->with('error', 'Something went wrong while submitting your KYC. Please try again.');
    }
}

public function generateKYCToken(){
    $client->update(['kyc_token' => Str::uuid()]);
}


}
