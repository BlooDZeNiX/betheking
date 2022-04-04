<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\StreamVotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rules\Password;
use Laravel\Sanctum\NewAccessToken;

/**
 * Class AuthController
 *
 * @author  cmsf <cesarmsfelipe@gmail.com>
 * @package App\Http\Controllers
 */
class VoteController extends Controller
{
    public function voteGame($vote)
    {
        /** @var \App\Models\StreamVotes $vote */
        $vote = StreamVotes::create([
            'voter' => $vote['voter'],
            'game_voted' => $vote['gameVoted'],
        ]);

        return $vote;
    }

    public function voteStreamer($vote)
    {
        /** @var \App\Models\StreamVotes $vote */
        $vote = StreamVotes::create([
            'voter' => $vote['voter'],
            'streamer_voted' => $vote['streamerVoted'],
        ]);

        return $vote;
    }
}
