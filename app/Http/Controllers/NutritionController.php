<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\NutritionResult;

class NutritionController extends Controller
{
    
    public function scan()
{
    return view('nutrition.scan');
}

public function analyze(Request $request)
{
    $request->validate([
        'image_data' => 'required|string',
    ]);

    // Decode base64
    $imageData = $request->input('image_data');
    $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
    $filename = 'scan_' . time() . '.jpg';
    Storage::disk('public')->put("uploads/{$filename}", $image);

    $base64 = base64_encode($image);

    // Kirim ke Gemini AI
    $response = Http::post(
        'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' .env('GEMINI_API_KEY'),
        [
            'contents' => [[
                'parts' => [
                    ['inline_data' => ['mime_type' => 'image/jpeg', 'data' => $base64]],
                    ['text' => 'Analisis perkiraan nutrisi secara umum dan hitung kalori pada makanan tersebut serta berikan resep makanan yang sehat.']
                ]
            ]]
        ]
    );

    $result = $response->json();
    $output = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Tidak ada hasil.';
    NutritionResult::create([
        'user_id' => auth()->id(),
        'image_path' => "uploads/{$filename}",
        'analysis' => json_encode($result),
    ]);

    return view('nutrition.result', ['result' => $result, 'output' => $output]);
}

}
