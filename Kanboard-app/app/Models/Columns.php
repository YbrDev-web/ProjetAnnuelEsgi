<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Columns extends Model
{
    public function tasks() {
        return $this->hasMany(Tasks::class);
    }
    public function project() {
        return $this->belongsTo(Project::class);
    }    
}
