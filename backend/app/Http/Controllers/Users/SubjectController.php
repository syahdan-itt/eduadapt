<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subject = Subjects::get();

        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'Subject tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data subject berhasil diambil',
            'data' => $subject
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subject = Subjects::with('materials')->find($id);

        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'Subject tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail subject berhasil diambil',
            'data' => $subject
        ], 200);
    }

}
