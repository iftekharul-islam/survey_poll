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
    Schema::create('exam_questions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
      $table->foreignId('question_id')->constrained()->cascadeOnDelete();
      $table->foreignId('answer_id')->nullable()->constrained('question_options')->cascadeOnDelete();
      $table->foreignId('right_id')->constrained('question_options')->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('exam_questions');
  }
};
