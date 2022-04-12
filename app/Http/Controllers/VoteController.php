<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\StreamVotes;
use App\Models\GameVotes;
use App\Models\Streamers;
use App\Models\Games;
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
    public function voteGame(Request $request)
    {
        /** @var \App\Models\GameVotes $vote */
        $vote = GameVotes::create([
            'voter' => $request['voter'],
            'game_voted' => $request['gameVoted'],
        ]);

        return response([
            $vote
        ]);
    }

    public function voteStreamer(Request $request)
    {
        /** @var \App\Models\StreamVotes $vote */
        $vote = StreamVotes::create([
            'voter' => $request['voter'],
            'streamer_voted' => $request['streamerVoted'],
        ]);

        return response([
            $vote,
        ]);
    }

    public function getUserVotes(Request $request)
    {
        $streamVotes = StreamVotes::where('voter', '=', $request['user_id'])->get();
        $gameVotes = GameVotes::where('voter', '=', $request['user_id'])->get();

        return ['streamVotes' => $streamVotes,
                'gameVotes' => $gameVotes,
        ];
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

        $topGames = GameVotes::select(
            'game_voted',
            GameVotes::raw('count("game_voted") as votes')
        )->groupBy('game_voted')
            ->orderByDesc('votes')
            ->take(10)->get()->toArray();
        $i = 0;
        foreach ($topGames as $key => $value) {
            $id = $topGames[$key]['game_voted'];
            $name = Games::select('name as game')
                ->where(
                    'id_game',
                    "=",
                    $id
                )->get()->toArray()[0]['game'];
            $topGames[$key]['game_voted'] = $name;
            $topGames[$key]['position'] = ++$i;
        }
        return ["topGames" => $topGames, "topStreams" => $topStreams];
    }
}
