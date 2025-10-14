<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYC Verification Wizard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#D4AF37',
                    },
                },
            },
        }
    </script>
</head>

<body class="bg-gray-100 font-sans antialiased">
<div x-data="{ step: 1 }" class="max-w-md mx-auto bg-white p-6 mt-10 rounded-2xl shadow-lg border border-gray-100">

    {{-- 🟡 Logo --}}
    <div class="flex justify-center mb-4">
        <img src="{{ asset('storage/'.$Settings->logo) }}" alt="Logo" class="h-14 object-contain">
    </div>

    {{-- Wizard Header --}}
    <div class="flex justify-between items-center mb-6">
        <template x-for="n in 3">
            <div class="flex-1 text-center">
                <div :class="step === n ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
                     class="w-8 h-8 rounded-full flex items-center justify-center mx-auto font-bold transition">
                    <span x-text="n"></span>
                </div>
                <p class="text-xs mt-1" x-text="['Info', 'Document', 'Liveliness'][n-1]"></p>
            </div>
        </template>
    </div>

    <form action="{{ route('kyc.public.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="client_id" value="{{ $client->id }}">

        {{-- STEP 1 --}}
        <div x-show="step === 1" x-transition>
            <h2 class="text-lg font-bold mb-2">Step 1: Personal Info</h2>
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Full Name</label>
                <input type="text" name="name" value="{{ $client->name }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Document Type</label>
                <select name="document_type" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                    <option value="">Select Document</option>
                    <option value="id_card">National ID</option>
                    <option value="passport">Passport</option>
                    <option value="driving_license">Driving License</option>
                </select>
            </div>

            <button type="button" @click="step++"
                    class="mt-4 w-full bg-gold text-white py-2 rounded hover:bg-yellow-500">
                Next
            </button>
        </div>

        {{-- STEP 2 --}}
        <div x-show="step === 2" x-transition>
            <h2 class="text-lg font-bold mb-2">Step 2: Upload Document</h2>
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Government Document Image</label>
                <input type="file" name="document_image" accept="image/*" class="w-full border rounded p-2" required>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" @click="step--"
                        class="px-4 py-2 rounded border border-gray-300 text-gray-600 hover:bg-gray-100">
                    Back
                </button>
                <button type="button" @click="step++"
                        class="px-4 py-2 bg-gold text-white rounded hover:bg-yellow-500">
                    Next
                </button>
            </div>
        </div>




        {{-- STEP 3 --}}
        {{--  --}}
<!-- Step 3: Smile ID -->
<div x-show="step === 3" x-transition class="space-y-4">
    <h2 class="text-lg font-bold">Step 3: Liveliness & Face Verification</h2>

    <div id="smileIDContainer" class="p-4 border rounded bg-gray-50 text-center">
        <p class="mb-3 text-sm text-gray-600">Click below to begin SmileID verification (liveliness + face capture).</p>

        <a href="https://links.sandbox.usesmileid.com/7578/ce4bd7ab-87df-4eea-a07e-3770e8829d0e" type="button"
                class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Start SmileID Verification
        </a>
    </div>

    <input type="hidden" name="smile_job_id" id="smileJobId">
    <input type="hidden" name="smile_result" id="smileResult">
</div>

{{-- Smile Identity Web SDK (load once at bottom of page) --}}
<script src="https://web-sdk.smileidentity.com/v1.0/smileidentity.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const startBtn = document.getElementById('startSmileBtn');
    if (!startBtn) return;

    startBtn.addEventListener('click', async () => {
        startBtn.disabled = true;
        startBtn.textContent = 'Starting...';

        try {
            // Request a short-lived signature from server
            const res = await fetch("{{ route('smile.init') }}");
            if (!res.ok) throw new Error('Failed to fetch signature from server');
            const cfg = await res.json();

            // Build the SmileIdentity SDK options using server data
            const smileOptions = {
                partner_id: cfg.partner_id,
                // The web SDK may expect 'auth_token' or 'signature' depending on version.
                // Check your SDK docs — below we use 'auth_token' as an example property name.
                auth_token: cfg.signature,
                timestamp: cfg.timestamp,
                environment: "{{ config('services.smile.environment', 'sandbox') }}",
            };

            // Initialize the SmileIdentity SDK
            const smile = new SmileIdentity(smileOptions);

            // Prepare job params — you can fill dynamically from Step 1 form fields
            const jobParams = {
                job_type: cfg.job_type || 5, // e.g. 5 = enhanced liveliness
                country: "{{ config('services.smile.country', 'KE') }}",
                // id_type and id_number can be passed dynamically if you have them
                // id_type: 'NATIONAL_ID',
                // id_number: '12345678',
            };

            // Start Smile flow
            const result = await smile.start(jobParams);

            // result shape depends on SDK — store useful bits in hidden fields
            document.getElementById('smileJobId').value = result.job_id || '';
            document.getElementById('smileResult').value = JSON.stringify(result || {});

            alert('SmileID verification completed successfully.');
        } catch (err) {
            console.error('SmileID error', err);
            alert('SmileID verification failed or was cancelled. See console for details.');
        } finally {
            startBtn.disabled = false;
            startBtn.textContent = 'Start SmileID Verification';
        }
    });
});
</script>

        {{--  --}}
    </form>
</div>

   {{-- ✅ Liveliness Test Partial --}}
    @include('kyc.partials.liveliness')


<footer class="text-center text-gray-400 text-xs mt-6">
    © {{ date('Y') }} {{ config('app.name') }} — Secure KYC Verification.
    <br>Powered by Confirm Diligence Solutions Limited
</footer>

<script>
    // You can add your live video logic here later
</script>

</body>
</html>
