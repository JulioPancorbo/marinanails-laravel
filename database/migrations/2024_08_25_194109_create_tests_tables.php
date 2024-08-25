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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE tests COMMENT = 'This table contains the tests of a lesson'");

        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('score', 4, 2)->comment('Puntuación del test, debe estar entre 0.00 y 10.00');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE test_results COMMENT = 'This table contains the results of a test made by a user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->dropForeign(['lesson_id']);
        });

        Schema::table('test_results', function (Blueprint $table) {
            $table->dropForeign(['test_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('tests');
        Schema::dropIfExists('test_results');
    }
};
