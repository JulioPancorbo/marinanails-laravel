<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_question_answers_given', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_question_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('test_question_option_id')
                ->comment('If the question is "single_choice" or "multiple_choice", this field will contain the option/s chosen by the user')
                ->nullable()
                ->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->text('written_answer')
                ->comment('If the question is "written_answer", this field will contain the written answer given by the user')
                ->nullable();
            $table->integer('numerical_answer')
                ->comment('If the question is "numerical_answer", this field will contain the numerical answer given by the user')
                ->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE test_question_answers_given COMMENT = 'This table contains the answers given by a user to a question of a test'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_question_answers_given', function (Blueprint $table) {
            $table->dropForeign(['test_question_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['test_question_option_id']);
        });
        Schema::dropIfExists('test_question_answers_given');
    }
};
