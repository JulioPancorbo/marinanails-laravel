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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });        
        DB::statement("ALTER TABLE lessons COMMENT = 'This table contains the lessons of a course, each lesson belongs to a section'");
            
        Schema::create('lesson_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE lesson_contents COMMENT = 'This table contains the content of a lesson, each lesson could have an image, a video or a document'");

        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE lesson_progress COMMENT = 'This table contains the progress of a lesson by a user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['section_id']);
        });

        Schema::table('lesson_contents', function (Blueprint $table) {
            $table->dropForeign(['lesson_id']);
        });

        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->dropForeign(['lesson_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('lessons');
        Schema::dropIfExists('lesson_contents');
        Schema::dropIfExists('lesson_progress');
    }
};
