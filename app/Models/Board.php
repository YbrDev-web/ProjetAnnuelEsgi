<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'board_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
        
   public function lists()
    {
        return $this->hasMany(BoardList::class);
    }

    public function cards()
    {
        return $this->hasManyThrough(Card::class, BoardList::class, 'board_id', 'list_id');
    }
    

}
