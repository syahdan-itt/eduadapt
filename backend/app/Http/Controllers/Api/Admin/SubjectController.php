<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @authenticated
 * @role 1 (admin teacher)
 */
class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @response 200
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Subjects::all());
    }

    /**
     * Display the specified resource.
     *
     * @response 200
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $subject = Subjects::with('materials')->find($id);
        if (!$subject) {
            return response()->json(['error' => 'Subject not found'], 404);
        }
        return response()->json($subject);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @response 201
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SubjectRequest $request): JsonResponse
    {
        $subject = Subjects::create([
            'name' => $request->name,
            'description' => $request->description ?? null,
        ]);
        return response()->json($subject, 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @response 200
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $subject = Subjects::find($id);
        if (!$subject) {
            return response()->json(['error' => 'Subject not found'], 404);
        }
        $subject->update([
            'name' => $request->name,
            'description' => $request->description ?? null,
        ]);
        return response()->json($subject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @response 204
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $subject = Subjects::find($id);
        if (!$subject) {
            return response()->json(['error' => 'Subject not found'], 404);
        }
        $subject->delete();
        return response()->json(['message' => 'Subject deleted'], 204);
    }
}
