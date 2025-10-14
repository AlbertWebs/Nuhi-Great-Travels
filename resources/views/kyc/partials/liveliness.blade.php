{{-- ✅ Face API --}}
<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', async function () {
    // Wait until Step 3 DOM is ready (handles Alpine render delays)
    function waitForElement(id, timeout = 5000) {
        return new Promise((resolve, reject) => {
            const interval = 100;
            let waited = 0;
            const check = setInterval(() => {
                const el = document.getElementById(id);
                if (el) {
                    clearInterval(check);
                    resolve(el);
                } else if ((waited += interval) >= timeout) {
                    clearInterval(check);
                    reject(new Error(`Element #${id} not found`));
                }
            }, interval);
        });
    }

    try {
        // Wait for instructionBox to exist
        await waitForElement('instructionBox');

        const video = document.getElementById('liveVideo');
        const canvas = document.getElementById('snapshotCanvas');
        const instructionBox = document.getElementById('instructionBox');
        const startTestBtn = document.getElementById('startTestBtn');
        const livelinessData = document.getElementById('livelinessData');
        const selfieImage = document.getElementById('selfieImage');

        const instructions = [
            "Blink your eyes",
            "Turn your head left",
            "Turn your head right",
            "Smile"
        ];

        let currentInstruction = "";
        let stream = null;
        let modelsLoaded = false;

        // Load models (only once)
        async function loadModels() {
            if (modelsLoaded) return;
            instructionBox.textContent = "Loading face detection models...";
            await Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
                faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
                faceapi.nets.faceExpressionNet.loadFromUri('/models')
            ]);
            modelsLoaded = true;
            instructionBox.textContent = "Models loaded. Ready to start.";
        }

        // Start camera
        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
                return true;
            } catch (err) {
                alert('Camera access denied or unavailable.');
                console.error('Camera Error:', err);
                return false;
            }
        }

        // Capture frame from video
        function captureFrame() {
            const ctx = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0);
            return canvas.toDataURL('image/png');
        }

        // Detect single face
        async function detectFace() {
            return await faceapi
                .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks()
                .withFaceExpressions();
        }

        // Upload to Laravel
        async function uploadImage(base64, details) {
            try {
                const response = await fetch("{{ route('kyc.liveliness.upload') }}", {
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

                if (!response.ok) {
                    const text = await response.text();
                    console.error('Upload failed:', text);
                    alert('❌ Upload failed. Please check console.');
                    return;
                }

                const data = await response.json();
                if (data.success) {
                    livelinessData.value = JSON.stringify(data.details);
                    selfieImage.value = data.image_path;
                    instructionBox.textContent = "✅ Liveliness test passed!";
                    alert("✅ Liveliness test passed and selfie captured!");
                } else {
                    console.error('Server Error:', data);
                    alert("❌ Upload failed on server.");
                }
            } catch (error) {
                console.error('Upload Error:', error);
                alert("⚠️ An error occurred during upload.");
            }
        }

        // Start test logic
        startTestBtn.addEventListener('click', async () => {
            startTestBtn.disabled = true;
            startTestBtn.textContent = "Running Test...";

            await loadModels();
            const cameraReady = await startCamera();
            if (!cameraReady) {
                startTestBtn.disabled = false;
                startTestBtn.textContent = "Start Liveliness Test";
                return;
            }

            // Pick random instruction
            currentInstruction = instructions[Math.floor(Math.random() * instructions.length)];
            instructionBox.textContent = "Instruction: " + currentInstruction;

            // Wait 4 seconds for user to respond
            setTimeout(async () => {
                try {
                    const detection = await detectFace();

                    if (!detection) {
                        alert("❌ No face detected! Please face the camera clearly.");
                        instructionBox.textContent = "No face detected. Try again.";
                        return;
                    }

                    const confidence = (detection.detection.score * 100).toFixed(2);
                    if (confidence < 40) {
                        alert("⚠️ Low confidence in face detection. Try again.");
                        instructionBox.textContent = "Low confidence. Try again.";
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
                } finally {
                    if (stream) {
                        stream.getTracks().forEach(track => track.stop());
                    }
                    startTestBtn.disabled = false;
                    startTestBtn.textContent = "Start Liveliness Test";
                }
            }, 4000);
        });

    } catch (err) {
        console.error('Initialization Error:', err);
    }
});
</script>
