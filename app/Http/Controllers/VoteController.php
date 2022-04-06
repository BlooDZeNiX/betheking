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
 * Class VoteController
 *
 * @author  cmsf <cesarmsfelipe@gmail.com>
 * @package App\Http\Controllers
 */
class VoteController extends Controller
{
    public function voteGame($voteGame)
    {
        /** @var \App\Models\StreamVotes $vote */
        $vote = StreamVotes::create([
            'voter' => $vote['voter'],
            'game_voted' => $vote['gameVoted'],
        ]);

        return response([
            $vote
        ]);
    }

    public function voteStreamer(Request $request)
    {
        // return dd($voteStream);
        /** @var \App\Models\StreamVotes $vote */
        $vote = StreamVotes::create([
            'voter' => $request['voter'],
            'streamer_voted' => $request['streamerVoted'],
        ]);

        return response([
            $vote,
        ]);
    }
}
