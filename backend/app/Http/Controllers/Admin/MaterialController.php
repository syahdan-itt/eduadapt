<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaterialRequest;
use App\Models\Materials;
use App\Models\Quizzes;
use App\Services\Ai\GeminiServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @authenticated
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
     * @response 200
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $materials = $user->materials()->with('versions', 'quizzes.options')->get();

        return response()->json($materials);
    }


    /**
     * Find a material by ID for the authenticated user
     *
     * @response = 200
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $material = Materials::with('versions', 'quizzes.options')
            ->where('created_by', Auth::id())
            ->find($id);

        if (!$material) {
            return response()->json(['error' => 'Material not found'], 404);
        }

        if ($material->created_by != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($material);
    }


    /**
     * Create a new material for the authenticated user
     *
     * @response 201
     * @return JsonResponse
     */
    public function store(MaterialRequest $request): JsonResponse
    {
        $aiData = $this->gemini->generateAdaptiveContent($request->content_text);

        if (!$aiData) return response()->json(['error' => 'AI Generate Adaptive Content Failed'], 500);

        return DB::transaction(function () use ($request, $aiData) {
            // 1. Store into materials table
            $material = Materials::create([
                'subject_id' => $request->subject_id,
                'title' => $request->title,
                'content_text' => $request->content_text,
                'difficulty' => $request->difficulty ?? 'easy', // Default
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
                    'question_type' => $q['question_type'],
                    'difficulty' => $q['difficulty'],
                ]);

                foreach ($q['options'] as $opt) {
                    $quiz->options()->create([
                        'selected_option' => $opt['selected_option'],
                        'answer_text' => $opt['answer_text'],
                        'is_correct' => $opt['is_correct'],
                    ]);
                }
            }

            return response()->json([
                'message' => 'Materi Adaptif Berhasil Dibuat',
                'material' => [
                    'id' => $material->id,
                    'subject_id' => $material->subject_id,
                    'title' => $material->title,
                    'content_text' => $material->content_text,
                    'difficulty' => $material->difficulty,
                    'created_by' => $material->created_by
                ],
            ], 201);
        });
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
        $material = Materials::find($id);

        if (!$material)
            return response()->json(['error' => 'Material not found'], 404);

        if ($material->created_by != Auth::id())
            return response()->json(['error' => 'Unauthorized'], 401);

        if ($request->content_text != $material->content_text) {
            $aiData = $this->gemini->generateAdaptiveContent($request->content_text);

            if (!$aiData) return response()->json(['error' => 'AI Processing Failed'], 500);

            return DB::transaction(function () use ($material, $request, $aiData) {
                // Update the material
                $material->update([
                    'subject_id' => $request->subject_id,
                    'title' => $request->title,
                    'content_text' => $request->content_text,
                    'difficulty' => $request->difficulty ?? 'easy', // Default
                ]);

                // Update versions
                $types = collect($aiData['versions'])->pluck('type')->toArray();
                $material->versions()->whereNotIn('version_type', $types)->delete();
                foreach ($aiData['versions'] as $v) {
                    $material->versions()->updateOrCreate(
                        ['version_type' => $v['type']],
                        ['content' => $v['content']]
                    );
                }

                // Update quizzes and options
                $material->quizzes()->with('options')->delete();
                foreach ($aiData['quizzes'] as $q) {
                    $quiz = $material->quizzes()->create([
                        'question' => $q['question'],
                        'question_type' => $q['question_type'],
                        'difficulty' => $q['difficulty'],
                    ]);

                    foreach ($q['options'] as $opt) {
                        $quiz->options()->create([
                            'answer_text' => $opt['answer_text'],
                            'is_correct' => $opt['is_correct'],
                        ]);
                    }
                }

                return response()->json([
                    'message' => 'Material Updated Successfully',
                    'material' => $material
                ]);
            });
        } else {

            $material->update([
                'subject_id' => $request->subject_id,
                'title' => $request->title,
                'difficulty' => $request->difficulty ?? 'easy', // Default
            ]);

            return response()->json([
                'message' => 'Material Updated Successfully',
                'material' => $material
            ]);
        }
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
