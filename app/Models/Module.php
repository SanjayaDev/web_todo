<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
  protected $guarded = ["id"];

  public function childs() 
  {
    return $this->hasMany(Module::class, "parent_id", "id");
  }

  public function roles()
  {
    return $this->hasMany(ModuleRole::class);
  }
}
