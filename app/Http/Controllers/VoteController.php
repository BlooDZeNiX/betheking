<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\StreamVotes;
use App\Models\Votes;
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

        Votes::create([
            'voter' => $request['voter'],
            'vote' => $vote['id'],
            'name_voted' => $request['name'],
            'type' => 'game',
        ]);

        return response([
            $vote
        ]);
    }

    public function voteStreamer(Request $request)
    {
        /** @var \App\Models\StreamVotes $vote */
        $streamVote = StreamVotes::create([
            'voter' => $request['voter'],
            'streamer_voted' => $request['streamerVoted'],
        ]);

        $vote = Votes::create([
            'voter' => $request['voter'],
            'vote' => $streamVote['id'],
            'name_voted' => $request['streamerLogin'],
            'type' => 'streamer',
        ]);

        return response([
            $vote,
        ]);
    }

    public function getUserVotes(Request $request)
    {
        $votes = Votes::where('voter', '=', $request['id'])->take(10)->get();
        $favorites = $this->getUserFavorites($request['id']);
        return [
            "votes" => $votes, "favorites" => [
               "game" => $favorites['game']['name_voted'],
               "streamer" => $favorites['streamer']['name_voted'],
            ]
        ];
    }

    public function getUserFavorites($id)
    {
        $favorites['game'] = Votes::select('name_voted', Votes::raw('count("name_voted") as votes'))->where('voter', $id)->where('type', 'game')->groupBy('name_voted')->orderByDesc('votes')->first();
        $favorites['streamer'] = Votes::select('name_voted', Votes::raw('count("name_voted") as votes'))->where('voter', $id)->where('type', 'streamer')->groupBy('name_voted')->orderByDesc('votes')->first();

        return $favorites;
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

        $streamVotes = StreamVotes::select('voter', StreamVotes::raw('count("voter") as votes'))->groupBy('voter')->get()->toArray();
        $gameVotes = GameVotes::select('voter', GameVotes::raw('count("voter") as votes'))->groupBy('voter')->get()->toArray();
        $i = 0;
        foreach ($gameVotes as $key => $value) {
            foreach ($streamVotes as $key2 => $value2) {
                if ($value['voter'] == $value2['voter']) {
                    $votes[] = ["voter" => User::select('username')->where('id', '=', $value['voter'])->get()->toArray()[0]['username'], "votes" => $value['votes'] + $value2['votes'], "position" => ++$i];
                }
            }
        }


        return ["topGames" => $topGames, "topStreams" => $topStreams, "topVoters" =>  $votes,];
    }
}
