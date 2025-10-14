<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
window.initLivelinessTest = async function () {
    const video = document.getElementById('liveVideo');
    const canvas = document.getElementById('snapshotCanvas');
    const instructionBox = document.getElementById('instructionBox');
    const startTestBtn = document.getElementById('startTestBtn');
    const livelinessData = document.getElementById('livelinessData');
    const selfieImage = document.getElementById('selfieImage');

    if (!instructionBox) {
        console.error("❌ instructionBox not found. Step 3 not yet visible.");
        return;
    }

    const instructions = ["Blink your eyes", "Turn your head left", "Turn your head right", "Smile"];
    let currentInstruction = "";
    let stream = null;

    // Load models if not already loaded
    if (!window.faceModelsLoaded) {
        instructionBox.textContent = "Loading face detection models...";
        await Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
            faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
            faceapi.nets.faceExpressionNet.loadFromUri('/models')
        ]);
        window.faceModelsLoaded = true;
    }

    instructionBox.textContent = "Models ready. Click start.";

    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        } catch (err) {
            alert('Camera access denied or unavailable.');
            console.error('Camera Error:', err);
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
        return await faceapi
            .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceExpressions();
    }

    async function uploadImage(base64, details) {
        const response = await fetch("{{ route('kyc.liveliness.upload') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ image: base64, instruction: currentInstruction, details })
        });
        const data = await response.json();
        if (data.success) {
            livelinessData.value = JSON.stringify(data.details);
            selfieImage.value = data.image_path;
            instructionBox.textContent = "✅ Liveliness test passed!";
            alert("✅ Test passed!");
        } else {
            alert("❌ Upload failed.");
        }
    }

    startTestBtn.addEventListener('click', async () => {
        await startCamera();
        currentInstruction = instructions[Math.floor(Math.random() * instructions.length)];
        instructionBox.textContent = "Instruction: " + currentInstruction;

        setTimeout(async () => {
            const detection = await detectFace();
            if (!detection) {
                alert("No face detected!");
                return;
            }

            const confidence = (detection.detection.score * 100).toFixed(2);
            if (confidence < 40) {
                alert("Low confidence. Try again.");
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

            if (stream) stream.getTracks().forEach(t => t.stop());
        }, 4000);
    });
};
</script>
