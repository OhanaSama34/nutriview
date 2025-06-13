<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\NutritionResult;
use Illuminate\Support\Str; // Import the Str facade for string manipulation

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
        // Clean data URI prefix before decoding
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
        $filename = 'scan_' . time() . '.jpg';
        Storage::disk('public')->put("uploads/{$filename}", $image);

        $base64 = base64_encode($image);

        // Send to Gemini AI
        $response = Http::post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . env('GEMINI_API_KEY'),
            [
                'contents' => [[
                    'parts' => [
                        ['inline_data' => ['mime_type' => 'image/jpeg', 'data' => $base64]],
                        ['text' => 'Anda adalah ahli gizi bersertifikat dan konsultan kuliner profesional, analisis menyeluruh terhadap komposisi makanan yang diberikan, baik berdasarkan gambar maupun nama makanan. Estimasi kandungan gizi per 100 gram, mencakup makronutrien seperti kalori, protein, lemak, dan karbohidrat, serta mikronutrien penting termasuk serat, vitamin, dan mineral. Berdasarkan analisis tersebut, berikan penilaian mengenai keseimbangan gizi makanan tersebut, misalnya apakah tinggi protein, rendah serat, atau karakteristik gizi lainnya. Selanjutnya, rekomendasikan satu resep makanan sehat dan seimbang yang terinspirasi dari makanan tersebut. Resep ini akan dirancang sesuai dengan prinsip gizi seimbang, cocok untuk dikonsumsi sehari-hari, dan disertai dengan takaran bahan serta langkah pembuatan yang jelas. Selain itu, berikan estimasi kandungan gizi per porsi, sehingga saya dapat memahami nilai nutrisi yang terkandung dalam hidangan tersebut.']
                    ]
                ]]
            ]
        );

        $result = $response->json();
        $output = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Tidak ada hasil.';
        $output = preg_replace("/\n{2,}/", "\n\n", $output);
        $output = preg_replace("/^[ \t]+/m", "", $output);
        $output = preg_replace("/[ \t]+$/m", "", $output);
        $output = trim($output);


        NutritionResult::create([
            'user_id' => auth()->id(),
            'image_path' => "uploads/{$filename}",
            'analysis' => json_encode($result),
            'plain_analysis' => $output,
        ]);

        // Send the cleaned output to the view
        return view('nutrition.result', ['result' => $result, 'output' => $output]);
    }
}