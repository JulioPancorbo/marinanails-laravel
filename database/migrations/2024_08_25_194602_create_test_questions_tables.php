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
        Schema::create('test_question_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE test_question_types COMMENT = 'This table contains the different types of questions that a test_question can be'");

        Schema::create('test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('test_question_type_id')->constrained();
            $table->text('text');
            $table->text('decription')->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE test_questions COMMENT = 'This table contains the questions of a test'");

        Schema::create('test_question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_question_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->text('text');
            $table->text('explanation')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
        DB::statement("ALTER TABLE test_question_options COMMENT = 'This table contains the options/answers of a question of a test'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_questions', function (Blueprint $table) {
            $table->dropForeign(['test_id']);
            $table->dropForeign(['test_question_type_id']);
        });

        Schema::table('test_question_options', function (Blueprint $table) {
            $table->dropForeign(['test_question_id']);
        });

        Schema::dropIfExists('test_questions');
        Schema::dropIfExists('test_question_options');
        Schema::dropIfExists('test_question_types');
    }
};
