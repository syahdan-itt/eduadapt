<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialRequest;
use App\Models\Materials;
use App\Services\Ai\GeminiServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * role = teacher
 */
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
     * @authenticated
     * @response 200
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        $materials = $user->materials()->with('versions', 'quizzes.options')->get();

        return response()->json($materials);
    }

    /**
     * Create a new material for the authenticated user
     *
     * @authenticated
     * @response 201
     * @return JsonResponse
     */
    public function store(MaterialRequest $request): JsonResponse
    {
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

    /**
     * Find a material by ID for the authenticated user
     *
     * @param int $id
     */
    public function show($id): JsonResponse
    {
        $material = Materials::with('versions', 'quizzes.options')
            ->where('created_by', Auth::id())
            ->find($id);

        if (!$material) {
            return response()->json(['error' => 'Material not found'], 404);
        }

        return response()->json($material);
    }

    /**
     * Update a material by ID for the authenticated user
     *
     * @authenticated
     * @response 200
     * @return JsonResponse
     */
    public function update(MaterialRequest $request, $id)
    {
        $material = Materials::where('created_by', Auth::id())->find($id);

        if (!$material) {
            return response()->json(['error' => 'Material not found'], 404);
        }

        $aiData = $this->gemini->generateAdaptiveContent($request->content_text);

        if (!$aiData) return response()->json(['error' => 'AI Processing Failed'], 500);

        return DB::transaction(function () use ($material, $request, $aiData) {
            // Update the material
            $material->update([
                'subject_id' => $request->subject_id,
                'title' => $request->title,
                'content_text' => $request->content_text,
                'difficulty' => 'medium', // Default
            ]);

            // Update versions
            foreach ($aiData['versions'] as $v) {
                $material->versions()->create([
                    'version_type' => $v['type'],
                    'content' => $v['content'],
                ]);
            }

            // Update quizzes and options
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

            return response()->json(['message' => 'Material Updated Successfully']);
        });
    }

    /**
     * Delete a material by ID for the authenticated user
     *
     * @authenticated
     * @response 200
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $material = Materials::where('created_by', Auth::id())->find($id);

        if (!$material) {
            return response()->json(['error' => 'Material not found'], 404);
        }

        $material->delete();

        return response()->json(['message' => 'Material Deleted Successfully']);
    }
}
