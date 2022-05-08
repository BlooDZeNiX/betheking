<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    use HasFactory;

    protected $fillable = [
        'voter',
        'vote',
        'name_voted',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "id");
    }

}
