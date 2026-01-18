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
            2. Buat 10 Soal Kuis dengan tipe berbeda:
               - 'multiple_choice': Soal pilihan ganda dengan 4 opsi jawaban (buat 5 soal)
               - 'short_answer': Soal jawaban singkat (buat 3 soal)
               - 'long_answer': Soal jawaban panjang/esai (buat 2 soal)
               Variasikan difficulty: easy, medium, hard
            
            Struktur JSON:
            {
                \"versions\": [
                    {\"type\": \"full\", \"content\": \"...\"},
                    {\"type\": \"summary\", \"content\": \"...\"},
                    {\"type\": \"simple\", \"content\": \"...\"}
                ],
                \"quizzes\": [
                    {
                        \"question\": \"Pertanyaan pilihan ganda...\",
                        \"question_type\": \"multiple_choice\",
                        \"difficulty\": \"medium\",
                        \"options\": [
                            {\"selected_option\": \"A\", \"answer_text\": \"Jawaban A\", \"is_correct\": true},
                            {\"selected_option\": \"B\", \"answer_text\": \"Jawaban B\", \"is_correct\": false},
                            {\"selected_option\": \"C\", \"answer_text\": \"Jawaban C\", \"is_correct\": false},
                            {\"selected_option\": \"D\", \"answer_text\": \"Jawaban D\", \"is_correct\": false}
                        ]
                    },
                    {
                        \"question\": \"Pertanyaan jawaban singkat...\",
                        \"question_type\": \"short_answer\",
                        \"difficulty\": \"easy\",
                        \"options\": [
                            {\"selected_option\": null, \"answer_text\": \"Jawaban yang benar\", \"is_correct\": true}
                        ]
                    },
                    {
                        \"question\": \"Pertanyaan jawaban panjang/esai...\",
                        \"question_type\": \"long_answer\",
                        \"difficulty\": \"hard\",
                        \"options\": [
                            {\"selected_option\": null, \"answer_text\": \"Contoh jawaban yang diharapkan\", \"is_correct\": true}
                        ]
                    }
                ]
            }

            PENTING:
            - Untuk multiple_choice: buat 4 opsi (A, B, C, D) dengan satu jawaban benar
            - Untuk short_answer: buat 1 opsi dengan answer_text berisi jawaban yang benar
            - Untuk long_answer: buat 1 opsi dengan answer_text berisi contoh/poin jawaban yang diharapkan
            - Pastikan total 10 soal: 5 multiple_choice, 3 short_answer, 2 long_answer
            - Hanya kembalikan JSON murni tanpa markdown code block

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
