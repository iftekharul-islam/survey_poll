<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
  use HasFactory;

  protected $fillable = ['country_id', 'name', 'description'];

  public function country()
  {
    return $this->belongsTo(Country::class);
  }

  public function questions()
  {
    return $this->hasMany(Question::class);
  }
}
