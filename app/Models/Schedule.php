<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($schedule) {
            // Set the user_id when a schedule is created
            $schedule->user_id = auth()->user()->id;
        });
    }

    // include global scope
    protected static function booted()
    {
        static::addGlobalScope(new Scopes\UserScope);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
