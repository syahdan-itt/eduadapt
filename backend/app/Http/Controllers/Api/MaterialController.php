<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Materials;
use App\Services\Ai\GeminiServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    /** @var GeminiServices $gemini */
    protected $gemini;

    public function __construct(GeminiServices $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Get all materials for the authenticated user
     *
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $materials = $user->materials()->with('versions', 'quizzes.options')->get();

        return response()->json($materials);
    }

    /**
     * Create a new material for the authenticated user
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required',
            'content_text' => 'required|min:200',
        ]);

        $aiData = $this->gemini->generateAdaptiveContent($request->content_text);

        if (!$aiData) return response()->json(['error' => 'AI Processing Failed'], 500);

        return DB::transaction(function () use ($request, $aiData) {
            // 1. Store into materials table
            $material = Materials::create([
                'subject_id' => $request->subject_id,
                'title' => $request->title,
                'content_text' => $request->content_text,
                'difficulty' => 'medium', // Default
                'created_by' => Auth::id(),
            ]);

            // 2. Store into material_versions table (Adaptive Content)
            foreach ($aiData['versions'] as $v) {
                $material->versions()->create([
                    'version_type' => $v['type'],
                    'content' => $v['content'],
                ]);
            }

            // 3. Store into quizzes & quiz_options table
            foreach ($aiData['quizzes'] as $q) {
                $quiz = $material->quizzes()->create([
                    'question' => $q['question'],
                    'difficulty' => $q['difficulty'],
                ]);

                foreach ($q['options'] as $opt) {
                    $quiz->options()->create([
                        'option_text' => $opt['text'],
                        'is_correct' => $opt['is_correct'],
                    ]);
                }
            }

            return response()->json(['message' => 'Materi Adaptif Berhasil Dibuat'], 201);
        });
    }
}
