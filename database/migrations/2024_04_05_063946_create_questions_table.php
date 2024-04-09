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
    Schema::create('questions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('group_id');
      $table->foreignId('country_id')->constrained()->cascadeOnDelete();
      $table->text('question');
      $table->integer('points');
      $table->integer('right_id')->nullable();
      $table->tinyInteger('is_associated')->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('questions');
  }
};
