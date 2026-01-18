<?php

namespace Database\Seeders;

use App\Models\Subjects;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $math = Subjects::create([
            'name' => 'Math',
            'description' => 'Math subject',
        ]);

        Subjects::create([
            'name' => 'Science',
            'description' => 'Science subject',
        ]);

        Subjects::create([
            'name' => 'History',
            'description' => 'History subject',
        ]);

        $user = User::where('role', 1)->first();

        $math->materials()->create([
            'title' => 'Math Material 1 Title',
            'content_text' => 'Math material 1 content',
            'difficulty' => 'easy',
            'created_by' => $user->id,
        ]);
    }
}
