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
    Schema::create('exams', function (Blueprint $table) {
      $table->id();
      $table->foreignId('country_id')->constrained()->cascadeOnDelete();
      $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
      $table->string('name');
      $table->string('email');
      $table->string('range');
      $table->integer('final_score')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('exams');
  }
};
