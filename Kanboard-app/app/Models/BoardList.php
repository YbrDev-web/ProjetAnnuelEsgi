<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardList extends Model // ou ListModel
{
    protected $fillable = ['title', 'board_id', 'is_terminal'];

    public function cards()
{
    return $this->hasMany(Card::class, 'list_id');
}


    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}
