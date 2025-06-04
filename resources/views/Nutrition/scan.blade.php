@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Scan Makanan dengan Kamera</h2>

    <!-- Pilihan kamera -->
    <label for="cameraSelect" class="block mb-2 font-medium">Pilih Kamera:</label>
    <select id="cameraSelect" class="mb-4 border rounded p-2 w-full"></select>

    <!-- Video & canvas -->
    <video id="video" width="100%" autoplay playsinline class="rounded shadow mb-4 border"></video>
    <canvas id="canvas" class="hidden"></canvas>

    <!-- Form untuk submit gambar -->
    <form id="scanForm" method="POST" action="{{ route('analyze') }}">
        @csrf
        <input type="hidden" name="image_data" id="image_data">
        <button type="button" id="scanBtn" class="bg-blue-600 text-white px-4 py-2 rounded">Scan & Kirim</button>
    </form>
</div>

<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const scanBtn = document.getElementById('scanBtn');
    const imageInput = document.getElementById('image_data');
    const cameraSelect = document.getElementById('cameraSelect');

    let currentStream;

    // Ambil daftar perangkat kamera
    async function getCameras() {
        const devices = await navigator.mediaDevices.enumerateDevices();
        const videoDevices = devices.filter(device => device.kind === 'videoinput');

        cameraSelect.innerHTML = ''; // Bersihkan dulu

        videoDevices.forEach((device, index) => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.text = device.label || `Kamera ${index + 1}`;
            cameraSelect.appendChild(option);
        });

        if (videoDevices.length > 0) {
            startCamera(videoDevices[0].deviceId); // Otomatis nyalakan kamera pertama
        }
    }

    // Nyalakan kamera berdasarkan deviceId
    async function startCamera(deviceId) {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
        }

        const constraints = {
            video: {
                deviceId: { exact: deviceId }
            }
        };

        try {
            const stream = await navigator.mediaDevices.getUserMedia(constraints);
            video.srcObject = stream;
            currentStream = stream;
        } catch (err) {
            alert("Tidak bisa mengakses kamera: " + err.message);
        }
    }

    // Ubah kamera saat pilihan berubah
    cameraSelect.addEventListener('change', (e) => {
        startCamera(e.target.value);
    });

    // Ambil gambar dan kirim ke server
    scanBtn.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0);
        const imageData = canvas.toDataURL('image/jpeg');
        imageInput.value = imageData;
        document.getElementById('scanForm').submit();
    });

    // Jalankan saat halaman selesai dimuat
    window.addEventListener('DOMContentLoaded', () => {
        getCameras();
    });
</script>
@endsection
