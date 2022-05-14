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
    /**
     * Function to insert a vote in votes and game_votes in the database
     *
     * @param Request [id ter, id game voted, name of the voted]
     * @return Array vote
     */
    public function voteGame(Request $request)
    {
        $able = $this->isAbleToVoteGame($request['voter']);
        if ($able == 1) {
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
            $this->setGold($request['voter']);

            return response([
                $vote
            ]);
        } else {
            return $able;
        }
    }

    /**
     * Function to vote a Streamer
     *
     * @param Request [id voter, id streamer voted, login of the voted]
     * @return Array vote
     */
    public function voteStreamer(Request $request)
    {
        $able = $this->isAbleToVoteStreamer($request['voter']);
        if ($able == 1) {
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
            $this->setGold($request['voter']);

            return response([
                $vote,
            ]);
        } else {
            return $able;
        }
    }

    /**
     * Function to give 100 gold to an user
     *
     * @param [String] user's id
     * @return void
     */
    public function setGold($id)
    {
        $gold = User::select('gold')->where('id', $id)->get()->toArray()[0]['gold'] + 100;
        User::where('id', $id)
            ->update(['gold' => $gold]);
    }

    /**
     * Function to get user votes and favorites by his id
     *
     * @param Request $request
     * @return Array vots and favorites
     */
    public function getUserVotes(Request $request)
    {
        $votes = Votes::where('voter', '=', $request['id'])->orderBy("created_at", "desc")->take(10)->get();
        $favorites = $this->getUserFavorites($request['id']);
        return [
            "votes" => $votes, "favorites" => [
                "game" => $favorites['game'],
                "streamer" => $favorites['streamer'],
            ]
        ];
    }

    /**
     * Function to get user's favorites
     *
     * @param [String] $id
     * @return Array $favorites
     */
    public function getUserFavorites($id)
    {
        $favorites['game'] = Votes::select('name_voted', Votes::raw('count("name_voted") as votes'))->where('voter', $id)->where('type', 'game')->groupBy('name_voted')->orderByDesc('votes')->first() ? Votes::select('name_voted', Votes::raw('count("name_voted") as votes'))->where('voter', $id)->where('type', 'game')->groupBy('name_voted')->orderByDesc('votes')->first()->toArray()['name_voted'] : "";
        $favorites['streamer'] = Votes::select('name_voted', Votes::raw('count("name_voted") as votes'))->where('voter', $id)->where('type', 'streamer')->groupBy('name_voted')->orderByDesc('votes')->first() ? Votes::select('name_voted', Votes::raw('count("name_voted") as votes'))->where('voter', $id)->where('type', 'streamer')->groupBy('name_voted')->orderByDesc('votes')->first()->toArray()['name_voted'] : "";

        return $favorites;
    }

    /**
     * Function to get top 10 of voters, games voted and streamers voted
     *
     * @return Array top voted streamers, top voted games and voters
     */
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

        $Votes = Votes::select('voter', GameVotes::raw('count("voter") as votes'))->groupBy('voter')->get()->toArray();
        foreach ($Votes as $key => $value) {
            if ($value['voter']) {
                $votes[] = ["voter" => User::select('username')->where('id', '=', $value['voter'])->get()->toArray()[0]['username'], "votes" => $value['votes']];
            }
        }


        $col = array_column($votes, "votes");
        array_multisort($col, SORT_DESC, $votes);

        $i = 0;
        foreach ($votes as $key => $value) {
            $votes[$key]['position'] = ++$i;
        }

        return [
            "topGames" => $topGames,
            "topStreams" => $topStreams,
            "topVoters" =>  $votes,
        ];
    }

    /**
     * Function to get Today's votes
     *
     * @return Array Games' and Streamer's votes
     */
    public function getTodayVotes()
    {
        $streamVotes = StreamVotes::whereDate('created_at', Carbon::today())->get()->count();
        $gameVotes = GameVotes::whereDate('created_at', Carbon::today())->get()->count();

        return [
            "streamVotes" => $streamVotes,
            "gameVotes" => $gameVotes,
            "total" => $streamVotes + $gameVotes,
        ];
    }

    /**
     * Function to check if an user can vote a Game
     *
     * @param [string] $id user's id
     * @return Boolean
     */
    public function isAbleToVoteGame($id)
    {
        $created_at = Votes::where('voter', '=', $id)->where('type', '=', 'game')->orderBy("created_at", "desc")->take(1)->get()->toArray();
        $now = Carbon::now();
        if ($created_at) {
            if (((strtotime($now) - strtotime($created_at[0]['created_at'])) / 60) / 60 >= 1) {
                return true;
            } else {
                return 60 - ((strtotime($now) - strtotime($created_at[0]['created_at'])) / 60);
            }
        } else {
            return true;
        }
    }

    /**
     * Function to check if an user can vote a Streamer
     *
     * @param [String] $id user's id
     * @return Boolean
     */
    public function isAbleToVoteStreamer($id)
    {
        $created_at = Votes::where('voter', '=', $id)->where('type', '=', 'streamer')->orderBy("created_at", "desc")->take(1)->get()->toArray();
        $now = Carbon::now();
        if ($created_at) {
            if (((strtotime($now) - strtotime($created_at[0]['created_at'])) / 60) / 60 >= 1) {
                return true;
            } else {
                return 60 - ((strtotime($now) - strtotime($created_at[0]['created_at'])) / 60);
            }
        } else {
            return true;
        }
    }
}
