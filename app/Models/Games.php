<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_game',
        'box_art_url',
        'name',
    ];

    public function gameVotes()
    {
        return $this->hasMany(GameVotes::class, 'id');
    }
}
