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
        <div id="step3" x-show="step === 3" class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-800">Step 3: Liveliness Test</h2>

            {{-- Instruction display --}}
            <div id="instructionBox" class="p-4 bg-blue-50 border border-blue-200 rounded text-blue-800 text-center">
                Click <strong>Start Liveliness Test</strong> to begin
            </div>

            {{-- Live video feed --}}
            <div class="flex justify-center">
                <video id="liveVideo" autoplay muted playsinline class="w-80 h-60 bg-black rounded-md"></video>
            </div>

            {{-- Hidden canvas to capture frame --}}
            <canvas id="snapshotCanvas" class="hidden"></canvas>

            {{-- Hidden form fields to hold liveliness results --}}
            <input type="hidden" name="livelinessData" id="livelinessData">
            <input type="hidden" name="selfieImage" id="selfieImage">

            {{-- Start test button --}}
            <div class="text-center">
                <button type="button" id="startTestBtn"
                    class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Start Liveliness Test
                </button>
            </div>
        </div>
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
