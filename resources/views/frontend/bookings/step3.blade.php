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
        <div x-show="step === 3" x-transition>
            <h2 class="text-lg font-bold mb-2">Step 3: Liveliness Test</h2>
            <p class="text-sm text-gray-600 mb-2">Ensure your camera is active and follow on-screen instructions.</p>

            <div class="border rounded p-3 bg-gray-50">
                <video id="liveVideo" width="100%" height="300" autoplay muted class="rounded mb-2"></video>
                <canvas id="snapshotCanvas" class="hidden"></canvas>

                <button type="button" id="startTestBtn"
                        class="bg-gold text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Start Liveliness Test
                </button>
            </div>

            <input type="hidden" name="liveliness_data" id="livelinessData">
            <input type="hidden" name="selfie_image" id="selfieImage">

            <div class="flex justify-between mt-4">
                <button type="button" @click="step--"
                        class="px-4 py-2 rounded border border-gray-300 text-gray-600 hover:bg-gray-100">
                    Back
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Submit KYC
                </button>
            </div>
        </div>
    </form>
</div>

   {{-- ✅ Liveliness Test Partial --}}
            <div class="border-t border-gray-200 pt-4">
                @include('kyc.partials.liveliness')
            </div>

<footer class="text-center text-gray-400 text-xs mt-6">
    © {{ date('Y') }} {{ config('app.name') }} — Secure KYC Verification.
    <br>Powered by Confirm Diligence Solutions Limited
</footer>

<script>
    // You can add your live video logic here later
</script>

</body>
</html>
