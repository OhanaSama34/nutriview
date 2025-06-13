@extends('layouts.app')

@section('content')
<div class="text-center mt-8">
        <h1 class="text-2xl md:text-3xl font-bold text-green-800">Scan Food Calories</h1>
    </div>

    

    <div class="max-w-xl mx-auto py-10 px-4">
        <h2 class="text-lg font-bold text-green-800 mb-4 text-center">Start scanning your food</h2>
        <p class="text-gray-600 max-w-md mx-auto mt-2 text-center mb-6">
            Gunakan kamera perangkat Anda untuk mengambil gambar makanan. Kami akan menganalisisnya untuk Anda!
        </p>

        <div class="relative bg-gray-200 rounded-lg shadow-md overflow-hidden mb-6">
            <video id="video" width="100%" autoplay playsinline class="block"></video>
            <canvas id="canvas" class="hidden"></canvas>
        </div>
        <div class="mb-4">
            <label for="cameraSelect" class="block mb-2 font-medium text-gray-700">Pilih Kamera:</label>
            <select id="cameraSelect" class="block w-full border border-green-300 rounded-lg py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-green-500 bg-white shadow-sm"></select>
        </div>


        <form id="scanForm" method="POST" action="{{ route('analyze') }}" class="text-center">
            @csrf
            <input type="hidden" name="image_data" id="image_data">
            <button type="button" id="scanBtn" class="mt-4 px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-full font-semibold shadow-lg transition duration-200 ease-in-out transform hover:scale-105">
                Scan & Kirim
            </button>
        </form>
    </div>

    <footer class="mt-20 text-center text-sm text-gray-500 space-y-2 pb-6">
        <div class="flex justify-center space-x-10">
            <a href="#" class="hover:text-green-600">Privacy Policy</a>
            <a href="#" class="hover:text-green-600">Terms of Service</a>
            <a href="#" class="hover:text-green-600">Contact Us</a>
        </div>
        <p class="mt-2">&copy;2024 NutriView. Hak Cipta Dilindungi.</p>
    </footer>


<script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const scanBtn = document.getElementById('scanBtn');
        const imageInput = document.getElementById('image_data');
        const cameraSelect = document.getElementById('cameraSelect');

        let currentStream;

        async function getCameras() {
            try {
                const devices = await navigator.mediaDevices.enumerateDevices();
                const videoDevices = devices.filter(device => device.kind === 'videoinput');

                cameraSelect.innerHTML = '';

                if (videoDevices.length === 0) {
                    const option = document.createElement('option');
                    option.text = 'Tidak ada kamera ditemukan';
                    cameraSelect.appendChild(option);
                    scanBtn.disabled = true;
                    return;
                }

                videoDevices.forEach((device, index) => {
                    const option = document.createElement('option');
                    option.value = device.deviceId;
                    option.text = device.label || `Kamera ${index + 1}`;
                    cameraSelect.appendChild(option);
                });

                startCamera(videoDevices[0].deviceId);
            } catch (err) {
                console.error("Error enumerating devices:", err);
                alert("Gagal mengakses daftar kamera: " + err.message);
                scanBtn.disabled = true;
            }
        }

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
                console.error("Error accessing camera:", err);
                alert("Tidak bisa mengakses kamera: " + err.message);
                scanBtn.disabled = true;
            }
        }

        cameraSelect.addEventListener('change', (e) => {
            startCamera(e.target.value);
        });

        scanBtn.addEventListener('click', () => {
            if (!currentStream) {
                alert("Kamera belum siap atau tidak ada.");
                return;
            }
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL('image/jpeg');
            imageInput.value = imageData;
            document.getElementById('scanForm').submit();
        });

        window.addEventListener('DOMContentLoaded', () => {
            getCameras();
        });
    </script>
@endsection
