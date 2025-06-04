@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6">

    {{-- Judul Halaman --}}
    <h2 class="text-2xl font-semibold mb-4">Hasil Analisis Makanan</h2>

    {{-- Teks Output --}}
    <div class="bg-white shadow-md p-6 rounded-lg border whitespace-pre-line mb-6" id="outputText">
        {!! nl2br(e($output)) !!}
    </div>

    {{-- Tombol Ulangi Scan dan Dengarkan --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('scan') }}" class="text-blue-600 hover:underline">🔄 Scan Lagi</a>
        <button onclick="speakText()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            🔊 Dengarkan Hasil
        </button>
    </div>

    {{-- (Opsional) Debug JSON (hanya untuk admin/dev) --}}
    @if (app()->environment('local'))
    <div class="mt-8">
        <h3 class="text-sm font-semibold text-gray-500 mb-2">Debug JSON Response</h3>
        <pre class="bg-gray-100 p-4 rounded text-xs overflow-x-auto">{{ json_encode($result, JSON_PRETTY_PRINT) }}</pre>
    </div>
    @endif

</div>

<script>
    function speakText() {
        const outputText = document.getElementById('outputText');
        if (!outputText) return;

        const utterance = new SpeechSynthesisUtterance(outputText.innerText);
        utterance.lang = 'id-ID';
        speechSynthesis.cancel();
        speechSynthesis.speak(utterance);
    }

    // Putar suara otomatis saat halaman selesai dimuat
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            speakText();
        }, 400); // sedikit delay untuk memastikan halaman termuat
    });
</script>
@endsection
