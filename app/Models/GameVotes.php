<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameVotes extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'voter',
        'game_voted',
    ];

    public function game()
    {
        return $this->belongsTo(Games::class, 'id_game');
    }

    public function user()
    {
        return $this->belongsTo(User::class, "id");
    }
}
