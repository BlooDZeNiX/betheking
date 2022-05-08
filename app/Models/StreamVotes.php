<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamVotes extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'voter',
        'streamer_voted',
    ];

    public function streamer(){
       return $this->belongsTo(Streamer::class, "id_streamer");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "id");
    }
}
