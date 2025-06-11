<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    public function column() {
        return $this->belongsTo(Columns::class);
    }    
}
