<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your KYC</title>
    {{-- ✅ Tailwind CDN (lightweight build) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Optional: Tailwind custom colors --}}
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
    <div class="max-w-md mx-auto bg-white p-5 mt-10 rounded-2xl shadow-lg border border-gray-100">
        {{-- 🟡 Logo --}}
        <div class="flex justify-center mb-4">
            <img src="{{ asset('storage/'.$Settings->logo) }}" alt="Logo" class="h-14 object-contain">
        </div>
        <h1 class="text-2xl font-bold mb-2 text-center text-gray-800">Complete Your KYC</h1>
        <p class="text-gray-600 text-sm mb-6 text-center leading-relaxed">
            Please upload your government-issued document and complete the liveliness test.
        </p>

        <form id="kycForm"
              action="{{ route('kyc.public.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf
            <input type="hidden" name="client_id" value="{{ $client->id }}">

            {{-- Full Name --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                <input type="text"
                       name="name"
                       value="{{ $client->name }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-green-200"
                       required>
            </div>

            {{-- Document Type --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Document Type</label>
                <select name="document_type"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-green-200"
                        required>
                    <option value="">Select Document</option>
                    <option value="id_card">National ID</option>
                    <option value="passport">Passport</option>
                    <option value="driving_license">Driving License</option>
                </select>
            </div>

            {{-- Document Upload --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Government Document Image</label>
                <input type="file"
                       name="document_image"
                       accept="image/*"
                       capture="environment"
                       class="w-full text-sm text-gray-600 border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-green-200"
                       required>
            </div>

             <div class="mb-6 border-t pt-4">
            <h2 class="font-bold text-lg mb-2">Liveliness Test</h2>
            <p class="text-gray-600 mb-2">Ensure your camera is active and follow on-screen instructions.</p>

            <div class="border rounded p-4 bg-gray-50">
                <video id="liveVideo" width="100%" height="300" autoplay muted class="rounded mb-2"></video>
                <canvas id="snapshotCanvas" class="hidden"></canvas>

                <div id="instructionBox" class="font-semibold text-blue-600 mb-2"></div>

                <button type="button" id="startTestBtn"
                        class="bg-gold text-white px-4 py-2 rounded hover:bg-blue-700">
                    Start Liveliness Test
                </button>
            </div>

            <input type="hidden" name="liveliness_data" id="livelinessData">
            <input type="hidden" name="selfie_image" id="selfieImage">
        </div>


            {{-- ✅ Liveliness Test Partial --}}
            <div class="border-t border-gray-200 pt-4">
                @include('kyc.partials.liveliness')
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-green-600 text-white font-semibold py-2 rounded-md hover:bg-green-700 transition">
                Submit KYC
            </button>
        </form>
    </div>

    {{-- Add a soft footer for trust cues --}}
    <footer class="text-center text-gray-400 text-xs mt-6">
        © {{ date('Y') }} {{ config('app.name') }}. Secure KYC Verification.
        <br>
        Powered By Confirm Diligence Solutions Limited
    </footer>
</body>
</html>
