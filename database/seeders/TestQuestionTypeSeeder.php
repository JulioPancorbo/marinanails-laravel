<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestQuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'single_choice',
            'multiple_choice',
            'true_false',
            'written_answer',
            'numerical_answer'
        ];

        foreach ($types as $type) {
            \DB::table('test_question_types')->insert([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the database seeds.
     */
    public function down(): void {
        \DB::table('test_question_types')->truncate();
    }
}
