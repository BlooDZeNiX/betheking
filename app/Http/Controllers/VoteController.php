<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\StreamVotes;
use App\Models\Streamers;
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

    public function getTopVoted()
    {
        $topStreams = StreamVotes::select(
            'streamer_voted',
            StreamVotes::raw('count("streamer_voted") as votes')
        )
            ->groupBy('streamer_voted')
            ->orderByDesc('votes')
            ->take(10)->get()->toArray();
        $i = 0;
        foreach ($topStreams as $key => $value) {
            $id = $topStreams[$key]['streamer_voted'];
            $name = Streamers::select('display_name as streamer')
                ->where(
                    'id_streamer',
                    "=",
                    $id
                )->get()->toArray()[0]['streamer'];
            $topStreams[$key]['streamer_voted'] = $name;
            $topStreams[$key]['position'] = ++$i;
        }

        return $topStreams;
    }
}
