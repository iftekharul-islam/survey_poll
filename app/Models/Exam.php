<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
  use HasFactory;

  protected $fillable = ['country_id', 'topic_id', 'name', 'email', 'range', 'total_score', 'final_score'];

  public function country()
  {
    return $this->belongsTo(Country::class);
  }

  public function topic()
  {
    return $this->belongsTo(Topic::class);
  }

  public function questions()
  {
    return $this->hasMany(ExamQuestion::class);
  }
}
