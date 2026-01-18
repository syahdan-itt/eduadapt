<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quizzes;
use App\Models\QuizOptions;
use App\Models\QuizAttempts;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $materialId = $request->material_id;
        $quiz = $user->quizzes()->where('material_id', $materialId)->get();

        if (!$quiz) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data quiz berhasil diambil',
            'data' => $quiz
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function answerQuiz(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'selected_option_id' => 'required|exists:quiz_options,id',
            'time_spent' => 'nullable|integer|min:0',
        ]);

        $user = Auth::user();
        $quizId = $request->quiz_id;
        $selectedOptionId = $request->selected_option_id;
        $timeSpent = $request->time_spent ?? 0;

        // Check if quiz exists
        $quiz = Quizzes::find($quizId);
        if (!$quiz) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz tidak ditemukan',
                'data' => null
            ], 404);
        }

        // Check if selected option belongs to the quiz
        $selectedOption = QuizOptions::where('id', $selectedOptionId)
            ->where('quiz_id', $quizId)
            ->first();

        if (!$selectedOption) {
            return response()->json([
                'success' => false,
                'message' => 'Opsi jawaban tidak valid untuk quiz ini',
                'data' => null
            ], 400);
        }

        // Check if user already answered this quiz
        $existingAttempt = QuizAttempts::where('user_id', $user->id)
            ->where('quiz_id', $quizId)
            ->first();

        if ($existingAttempt) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menjawab quiz ini',
                'data' => $existingAttempt
            ], 400);
        }

        // Create quiz attempt
        $isCorrect = $selectedOption->is_correct;
        $attempt = QuizAttempts::create([
            'user_id' => $user->id,
            'quiz_id' => $quizId,
            'selected_option_id' => $selectedOptionId,
            'is_correct' => $isCorrect,
            'time_spent' => $timeSpent,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil disimpan',
            'data' => [
                'attempt_id' => $attempt->id,
                'quiz_id' => $quizId,
                'selected_option_id' => $selectedOptionId,
            ]
        ], 200);
    }

    /**
     * Get quiz result for a specific material
     */
    public function getQuizResult(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
        ]);

        $user = Auth::user();
        $materialId = $request->material_id;

        // Get all quizzes for this material
        $quizzes = Quizzes::where('material_id', $materialId)->get();
        $totalQuestions = $quizzes->count();

        if ($totalQuestions === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada quiz untuk materi ini',
                'data' => null
            ], 404);
        }

        // Get quiz IDs
        $quizIds = $quizzes->pluck('id');

        // Get user's attempts for these quizzes
        $attempts = QuizAttempts::where('user_id', $user->id)
            ->whereIn('quiz_id', $quizIds)
            ->get();

        $answeredQuestions = $attempts->count();
        $correctAnswers = $attempts->where('is_correct', true)->count();
        $wrongAnswers = $attempts->where('is_correct', false)->count();

        // Calculate score percentage
        $scorePercentage = $answeredQuestions > 0
            ? round(($correctAnswers / $answeredQuestions) * 100, 2)
            : 0;

        // Get detailed results with correct answers
        $detailedResults = [];
        foreach ($quizzes as $quiz) {
            $attempt = $attempts->where('quiz_id', $quiz->id)->first();
            $correctOption = $quiz->options()->where('is_correct', true)->first();

            $detailedResults[] = [
                'quiz_id' => $quiz->id,
                'question' => $quiz->question,
                'answered' => $attempt ? true : false,
                'selected_option_id' => $attempt ? $attempt->selected_option_id : null,
                'is_correct' => $attempt ? $attempt->is_correct : null,
                'correct_option' => $correctOption,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Hasil quiz berhasil diambil',
            'data' => [
                'total_questions' => $totalQuestions,
                'answered_questions' => $answeredQuestions,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'score_percentage' => $scorePercentage,
                'details' => $detailedResults,
            ]
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
