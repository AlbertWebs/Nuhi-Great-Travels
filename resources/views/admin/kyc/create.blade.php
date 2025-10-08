@extends('layouts.admin')

@section('content')
<div class="max-w-12xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">New KYC Submission</h1>

    <form id="kycForm" action="{{ route('admin.kyc.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Full Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Document Type</label>
            <select name="document_type" class="w-full border rounded px-3 py-2" required>
                <option value="">Select Document</option>
                <option value="id_card">National ID</option>
                <option value="passport">Passport</option>
                <option value="driving_license">Driving License</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Government Document Image</label>
            <input type="file" name="document_image" accept="image/*" class="w-full" required>
        </div>

        {{-- ✅ Liveliness Test Section --}}
        <div class="mb-6 border-t pt-4">
            <h2 class="font-bold text-lg mb-2">Liveliness Test</h2>
            <p class="text-gray-600 mb-2">Ensure your camera is active and follow on-screen instructions.</p>

            <div class="border rounded p-4 bg-gray-50">
                <video id="liveVideo" width="100%" height="300" autoplay muted class="rounded mb-2"></video>
                <canvas id="snapshotCanvas" class="hidden"></canvas>

                <div id="instructionBox" class="font-semibold text-blue-600 mb-2"></div>

                <button type="button" id="startTestBtn"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Start Liveliness Test
                </button>
            </div>

            <input type="hidden" name="liveliness_data" id="livelinessData">
            <input type="hidden" name="selfie_image" id="selfieImage">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Submit KYC
        </button>
    </form>
</div>

{{-- 🧠 Liveliness Test Script with Face Detection --}}
<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async function () {
    const video = document.getElementById('liveVideo');
    const canvas = document.getElementById('snapshotCanvas');
    const instructionBox = document.getElementById('instructionBox');
    const startTestBtn = document.getElementById('startTestBtn');
    const livelinessData = document.getElementById('livelinessData');
    const selfieImage = document.getElementById('selfieImage');

    let instructions = ["Blink your eyes", "Turn your head left", "Turn your head right", "Smile"];
    let currentInstruction = "";
    let stream;

    // ✅ Load Face API Models
    await Promise.all([
        faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
        faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
        faceapi.nets.faceExpressionNet.loadFromUri('/models')
    ]);

    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        } catch (err) {
            alert('Camera access denied or unavailable.');
            console.error(err);
        }
    }

    function captureFrame() {
        const ctx = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        ctx.drawImage(video, 0, 0);
        return canvas.toDataURL('image/png');
    }

    async function detectFace() {
        const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions();
        return detection;
    }

    async function uploadImage(base64, details) {
        const response = await fetch("{{ route('admin.kyc.liveliness.upload') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                image: base64,
                instruction: currentInstruction,
                details: details
            })
        });

        const data = await response.json();
        if (data.success) {
            livelinessData.value = JSON.stringify(data.details);
            selfieImage.value = data.image_path;
            alert("✅ Liveliness test passed and selfie captured!");
        } else {
            alert("❌ Failed to upload selfie. Try again.");
        }
    }

    startTestBtn.addEventListener('click', async () => {
        await startCamera();
        currentInstruction = instructions[Math.floor(Math.random() * instructions.length)];
        instructionBox.textContent = "Instruction: " + currentInstruction;

        // Wait 3 seconds before capture
        setTimeout(async () => {
            const detection = await detectFace();
            if (!detection) {
                alert("❌ No face detected! Please position your face in front of the camera.");
                return;
            }

            const confidence = (detection.detection.score * 100).toFixed(2);
            if (confidence < 60) {
                alert("⚠️ Low confidence in face detection. Try again.");
                return;
            }

            const snapshot = captureFrame();
            const details = {
                timestamp: new Date().toISOString(),
                instruction_followed: currentInstruction,
                detection_confidence: confidence,
                expressions: detection.expressions
            };

            await uploadImage(snapshot, details);
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        }, 4000);
    });
});
</script>

@endsection
