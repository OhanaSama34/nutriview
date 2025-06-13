@extends('layouts.app') {{-- Pastikan ini mengacu pada layout utama Anda yang berisi navbar/footer --}}

@section('content')

<div class="max-w-4xl mx-auto py-10 px-4">

    {{-- Header Section --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-green-800 mb-3">Hasil Analisis Nutrisi Makanan Anda</h1>
        <p class="text-gray-600 text-lg">Berikut adalah detail nutrisi dan rekomendasi resep yang kami temukan.</p>
    </div>

    {{-- Ringkasan Analisis Utama (Output Gemini API) --}}
    <div class="bg-white shadow-lg rounded-xl border border-green-200 p-8 mb-12 relative">
        <h3 class="text-xl font-semibold text-green-700 mb-4">Ringkasan Analisis:</h3>
        <div class="prose max-w-none text-gray-800 leading-relaxed overflow-hidden relative" id="outputTextContainer">
            <div id="outputTextContent" class="transition-all duration-300 ease-in-out">
                {{-- Menggunakan Parsedown untuk merender teks Markdown menjadi HTML --}}
                @php
                    $parsedown = new Parsedown();
                @endphp
                {!! $parsedown->text($output) !!} {{-- <<< Perubahan kunci di sini --}}
            </div>
            {{-- Overlay untuk gradien fade out --}}
            <div id="fadeOverlay" class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
        </div>
        <button id="toggleReadMore" class="mt-4 px-4 py-2 bg-green-100 text-green-700 rounded-full hover:bg-green-200 transition duration-200 hidden">
            Selengkapnya
        </button>
    </div>

    {{-- Nutritional Info --}}
    @if (!empty($nutritionalInfo))
        <div class="max-w-3xl mx-auto mt-12 px-4">
            <h2 class="text-2xl font-bold mb-6 text-green-800 text-center">Informasi Nutrisi</h2>
            <div class="divide-y divide-green-100 border border-green-200 rounded-lg bg-white shadow-lg overflow-hidden">
                @foreach ($nutritionalInfo as $key => $value)
                    <div class="flex justify-between items-center p-4 last:border-b-0">
                        <span class="text-gray-600 font-medium capitalize">{{ str_replace('_', ' ', $key) }}</span>
                        <span class="font-bold text-green-700">{{ $value }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Recipe Recommendations --}}
    @if (!empty($recipeRecommendations))
        <div class="max-w-4xl mx-auto mt-16 px-4">
            <h2 class="text-2xl font-bold mb-8 text-green-800 text-center">Rekomendasi Resep Sehat</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($recipeRecommendations as $recipe)
                    <div class="flex flex-col md:flex-row items-start justify-between gap-6 bg-white p-6 rounded-xl shadow-lg border border-green-100 transform transition duration-300 hover:scale-[1.01] hover:shadow-xl">
                        <div class="md:flex-grow">
                            <p class="text-sm {{ $recipe['type'] == 'Recommended' ? 'text-green-500' : 'text-gray-500' }} font-semibold mb-1">{{ $recipe['type'] }}</p>
                            <h3 class="text-xl font-bold text-green-800 mb-3">{{ $recipe['title'] }}</h3>
                            <p class="text-base text-gray-700 leading-relaxed">{{ $recipe['description'] }}</p>
                            <a href="{{ $recipe['link'] ?? '#' }}" class="inline-block mt-5 px-5 py-2.5 text-base bg-green-600 hover:bg-green-700 text-white rounded-full font-semibold transition duration-200 ease-in-out shadow-md">
                                Lihat Resep
                            </a>
                        </div>
                        @if (isset($recipe['image']))
                            <div class="flex-shrink-0 w-full md:w-48 h-36 md:h-32 overflow-hidden rounded-lg shadow-md mt-6 md:mt-0">
                                <img src="{{ asset($recipe['image']) }}" alt="{{ $recipe['title'] }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Action Buttons --}}
    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-16">
        <a href="{{ route('scan') }}" class="px-8 py-3 bg-green-100 border border-green-300 text-green-800 rounded-full font-semibold hover:bg-green-200 transition duration-200 ease-in-out shadow-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004 16.5v1a.5.5 0 00.5.5h15a.5.5 0 00.5-.5v-1a8.001 8.001 0 00-15.356-2m15.356 2H20M4 7V4m0 0H1V1m3 3L1 1" />
            </svg>
            Scan Makanan Lain
        </a>

        <button onclick="speakText()" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-full font-semibold transition duration-200 ease-in-out shadow-md flex items-center gap-2" title="Dengarkan Hasil">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l1.293-1.293A1 1 0 018 7.414v9.172a1 1 0 01-1.707.707L5.586 15z" />
            </svg>
            Dengarkan Hasil
        </button>
    </div>

    {{-- Optional: Debug JSON (hanya untuk admin/dev) --}}
    {{-- @if (isset($result) && app()->environment('local'))
    <div class="mt-12 p-6 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-sm font-bold text-gray-700 mb-3 border-b pb-2">Debug JSON Response (For Developers)</h3>
        <pre class="bg-gray-100 p-4 rounded text-xs text-gray-800 overflow-x-auto leading-normal">{{ json_encode($result, JSON_PRETTY_PRINT) }}</pre>
    </div>
    @endif --}}

</div>

<script>
    function speakText() {
        // Ambil teks dari innerText agar tidak membaca tag HTML
        const outputText = document.getElementById('outputTextContent');
        if (!outputText || !outputText.innerText.trim()) {
            console.warn("Tidak ada teks untuk diucapkan.");
            return;
        }

        const utterance = new SpeechSynthesisUtterance(outputText.innerText);
        utterance.lang = 'id-ID';
        utterance.pitch = 1;
        utterance.rate = 1;
        utterance.volume = 1;

        utterance.onerror = (event) => {
            console.error("Kesalahan SpeechSynthesisUtterance:", event.error);
            if (event.error === 'not-allowed') {
                alert('Akses suara diblokir. Pastikan situs ini diizinkan untuk memutar suara di pengaturan browser Anda.');
            }
        };

        speechSynthesis.cancel();
        speechSynthesis.speak(utterance);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const outputTextContainer = document.getElementById('outputTextContainer');
        const outputTextContent = document.getElementById('outputTextContent');
        const toggleButton = document.getElementById('toggleReadMore');
        const fadeOverlay = document.getElementById('fadeOverlay');
        const initialHeight = 150; // Tinggi awal sebelum dipotong, sesuaikan sesuai kebutuhan Anda

        let isExpanded = false;

        function checkAndToggleReadMore() {
            // Reset height to get true scrollHeight
            outputTextContent.style.maxHeight = 'none';
            const contentHeight = outputTextContent.scrollHeight;

            if (contentHeight > initialHeight) {
                // Content is taller than initialHeight, apply truncation
                outputTextContainer.style.maxHeight = `${initialHeight}px`;
                outputTextContainer.style.position = 'relative'; // Ensure position is relative for the overlay
                outputTextContainer.classList.add('overflow-hidden');
                fadeOverlay.classList.remove('hidden'); // Show fade overlay
                toggleButton.classList.remove('hidden'); // Show button

                // Set initial state of the button
                toggleButton.innerText = 'Selengkapnya';
                isExpanded = false;
            } else {
                // Content is not tall enough to require "read more"
                outputTextContainer.style.maxHeight = 'none';
                outputTextContainer.classList.remove('overflow-hidden');
                fadeOverlay.classList.add('hidden'); // Hide fade overlay
                toggleButton.classList.add('hidden'); // Hide button
            }
        }

        toggleButton.addEventListener('click', () => {
            if (isExpanded) {
                // Collapse
                outputTextContainer.style.maxHeight = `${initialHeight}px`;
                outputTextContainer.classList.add('overflow-hidden');
                fadeOverlay.classList.remove('hidden');
                toggleButton.innerText = 'Selengkapnya';
            } else {
                // Expand
                outputTextContainer.style.maxHeight = `${outputTextContent.scrollHeight}px`;
                outputTextContainer.classList.remove('overflow-hidden');
                fadeOverlay.classList.add('hidden');
                toggleButton.innerText = 'Sembunyikan';
            }
            isExpanded = !isExpanded;
        });

        // Initialize on load
        checkAndToggleReadMore();

        // Also call speakText on load as before
        setTimeout(() => {
            speakText();
        }, 800);
    });
</script>
@endsection