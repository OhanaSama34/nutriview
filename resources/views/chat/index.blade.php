@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto mt-6">
    <h2 class="text-xl font-bold mb-4">Chat dengan Ahli Gizi</h2>

    <div id="chat-box" class="border p-4 h-96 overflow-y-scroll bg-white mb-4 rounded shadow">
        {{-- Pesan akan muncul di sini --}}
    </div>

    <form id="chat-form" class="flex">
@if($doctor)
    <input type="hidden" id="receiver_id" value="{{ $doctor->id }}">
@else
    <p class="text-red-600">Tidak ada dokter yang tersedia untuk dihubungi.</p>
@endif

        <input type="text" id="message" class="flex-1 p-2 border rounded-l" placeholder="Ketik pesan..." autocomplete="off">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r">Kirim</button>
    </form>
</div>

<script>
    const myId = {{ auth()->id() }};

    function fetchMessages() {
        const receiverId = document.getElementById('receiver_id').value;

        fetch('/chat/messages?receiver_id=' + receiverId)
            .then(res => res.json())
            .then(data => {
                let html = '';
                data.forEach(msg => {
                    const isMine = msg.from_user === myId;
                    html += `<div class="${isMine ? 'text-right' : 'text-left'} my-1">
                        <span class="inline-block px-3 py-1 rounded-full ${isMine ? 'bg-blue-200' : 'bg-gray-200'}">
                            ${msg.message}
                        </span>
                    </div>`;
                });

                const chatBox = document.getElementById('chat-box');
                chatBox.innerHTML = html;
                chatBox.scrollTop = chatBox.scrollHeight;
            });
    }

    // Fetch pesan tiap 2 detik
    setInterval(fetchMessages, 2000);
    fetchMessages();

    // Kirim pesan
    document.getElementById('chat-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const receiverId = document.getElementById('receiver_id').value;
        const message = document.getElementById('message').value;

        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                receiver_id: receiverId,
                message: message
            })
        }).then(() => {
            document.getElementById('message').value = '';
            fetchMessages();
        });
    });
</script>

@endsection
