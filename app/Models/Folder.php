<?php

namespace App\Models;

use Illuminate\Databasue\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
  public function tasks()
  {
    return $this->hasMany('App\Models\Task');
  }
  // use HasFactory;
}
