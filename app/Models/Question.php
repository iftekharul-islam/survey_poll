<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  use HasFactory;

  protected $fillable = ['group_id', 'country_id', 'question', 'points', 'right_id'];


  //append group column to the field
  protected $appends = ['group'];


  public function getGroupAttribute()
  {
    $groups = config('survey.groups');
    return  collect($groups)->where('id', $this->group_id)->first() ?? null;
  }
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
