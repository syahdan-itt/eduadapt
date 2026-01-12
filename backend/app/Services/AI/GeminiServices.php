<?php

namespace App\Services\Ai;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;

class GeminiServices
{
  public function generateAdaptiveContent(string $rawText)
    {
        $prompt = "
            Bertindaklah sebagai AI EduAdapt. Analisis teks materi berikut dan hasilkan output JSON murni.
            
            Tugas:
            1. Buat 3 Versi Materi (version_type): 
               - 'full': Materi lengkap yang terstruktur.
               - 'summary': Ringkasan poin-poin penting.
               - 'simple': Penjelasan konsep dasar untuk siswa yang kesulitan.
            2. Buat 5 Soal Kuis (difficulty: easy/medium/hard).
            
            Struktur JSON:
            {
                \"versions\": [
                    {\"type\": \"full\", \"content\": \"...\"},
                    {\"type\": \"summary\", \"content\": \"...\"},
                    {\"type\": \"simple\", \"content\": \"...\"}
                ],
                \"quizzes\": [
                    {
                        \"question\": \"...\",
                        \"difficulty\": \"medium\",
                        \"options\": [
                            {\"text\": \"...\", \"is_correct\": true},
                            {\"text\": \"...\", \"is_correct\": false},
                            {\"text\": \"...\", \"is_correct\": false},
                            {\"text\": \"...\", \"is_correct\": false}
                        ]
                    }
                ]
            }

            Teks: $rawText
        ";

        try {
            Log::info("Starting Gemini API call...");
            $response = Gemini::generativeModel(model: 'gemini-2.5-flash')->generateContent($prompt);
            Log::info("Gemini API response received");
            $text = $response->text();
            Log::info("Response text: " . substr($text, 0, 500));
            $cleanJson = str_replace(['```json', '```'], '', $text);
            $cleanJson = trim($cleanJson);
            $decoded = json_decode($cleanJson, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("JSON decode error: " . json_last_error_msg());
                Log::error("Clean JSON: " . $cleanJson);
                return null;
            }
            
            return $decoded;
        } catch (\Exception $e) {
            Log::error("Gemini Error: " . $e->getMessage());
            Log::error("Gemini Error Trace: " . $e->getTraceAsString());
            return null;
        }
    }
}
