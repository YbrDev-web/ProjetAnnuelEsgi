<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['list_model_id', 'title', 'description'];

    public function list()
{
    return $this->belongsTo(BoardList::class, 'list_id');
}

    
}
