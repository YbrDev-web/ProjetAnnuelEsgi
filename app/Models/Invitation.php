<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_id',
        'user_id',
        'token',
        'role',
    ];

    /**
     * Relation : une invitation appartient à un tableau.
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Relation : une invitation est liée à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
