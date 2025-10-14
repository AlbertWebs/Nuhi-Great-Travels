<!-- ✅ Face API.js -->
<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const video = document.getElementById('liveVideo');
    const canvas = document.getElementById('snapshotCanvas');
    const instructionBox = document.getElementById('instructionBox');
    const startTestBtn = document.getElementById('startTestBtn');
    const livelinessData = document.getElementById('livelinessData');
    const selfieImage = document.getElementById('selfieImage');

    // 🔹 Safety check for required elements
    if (!video || !canvas || !startTestBtn) {
        console.error("Missing essential DOM elements: video, canvas, or startTestBtn.");
        return;
    }

    const instructions = ["Blink your eyes", "Turn your head left", "Turn your head right", "Smile"];
    let currentInstruction = "";
    let stream;

    // ✅ Load Face API Models
    try {
        await Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
            faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
            faceapi.nets.faceExpressionNet.loadFromUri('/models')
        ]);
        console.log("Face API models loaded successfully.");
    } catch (err) {
        alert("❌ Failed to load Face API models. Please check /models folder.");
        console.error(err);
        return;
    }

    // 🎥 Start Camera
    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        } catch (err) {
            alert("⚠️ Camera access denied or unavailable.");
            console.error(err);
        }
    }

    // 📸 Capture current frame
    function captureFrame() {
        const ctx = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        ctx.drawImage(video, 0, 0);
        return canvas.toDataURL('image/png');
    }

    // 🧠 Detect face and expressions
    async function detectFace() {
        return await faceapi
            .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceExpressions();
    }

    // ☁️ Upload captured image
    async function uploadImage(base64, details) {
        try {
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
                if (livelinessData) livelinessData.value = JSON.stringify(data.details);
                if (selfieImage) selfieImage.value = data.image_path;
                alert("✅ Liveliness test passed and selfie captured!");
            } else {
                alert("❌ Failed to upload selfie. Try again.");
            }
        } catch (err) {
            alert("⚠️ An error occurred during upload.");
            console.error(err);
        }
    }

    // ▶️ Start Test button click event
    startTestBtn.addEventListener('click', async () => {
        await startCamera();

        // Random instruction
        currentInstruction = instructions[Math.floor(Math.random() * instructions.length)];
        if (instructionBox) {
            instructionBox.textContent = "Instruction: " + currentInstruction;
        }

        // Wait before capture
        setTimeout(async () => {
            const detection = await detectFace();
            if (!detection) {
                alert("❌ No face detected! Please position your face in front of the camera.");
                return;
            }

            const confidence = (detection.detection.score * 100).toFixed(2);
            if (confidence < 60) {
                alert(`⚠️ Low face confidence (${confidence}%). Try again.`);
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

            // Stop camera stream
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        }, 4000);
    });
});
</script>
