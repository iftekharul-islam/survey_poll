<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  use HasFactory;

  protected $fillable = ['topic_id', 'question', 'marks', 'right_id'];

  public function topic()
  {
    return $this->belongsTo(Topic::class);
  }

  public function options()
  {
    return $this->hasMany(QuestionOption::class);
  }
}
