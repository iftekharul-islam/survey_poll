<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  use HasFactory;

  protected $fillable = ['topic_id', 'country_id', 'question', 'marks', 'right_id'];

  public function topic()
  {
    return $this->belongsTo(Topic::class);
  }

  public function country()
  {
    return $this->belongsTo(Country::class);
  }

  public function options()
  {
    return $this->hasMany(QuestionOption::class);
  }

  public function images()
  {
    return $this->hasMany(QuestionImage::class);
  }

  public function answer()
  {
    return $this->hasOne(QuestionOption::class, 'id', 'right_id');
  }
}
