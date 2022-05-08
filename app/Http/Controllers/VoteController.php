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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
            try{
            //     $mail = new PHPMailer;
            //     $mail->SMTPDebug = 0;
            //     $mail->isSMTP();
            //     $mail->Host = 'smtp.hostinger.com';
            //     $mail->Port = 465;
            //     $mail->SMTPAuth = true;
            //     $mail->Username = 'btk@betheking.online';
            //     $mail->Password = 'Fraternidad0=';
            //     $mail->setFrom('btk@betheking.online', 'BeTheKing');
            //     $mail->addAddress('cesarmsfelipe@gmail.com', 'Zenix');
            //     $mail->isHTML(true);
            //     $mail->Body = "done";
            //     $mail->Subject = 'Testing PHPMailer';
            //    $mail->send();
            }catch(Exception $e){
                return $e;
            }
            return $able;
        }
    }

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

    public function setGold($id)
    {
        $gold = User::select('gold')->where('id', $id)->get()->toArray()[0]['gold'] + 100;
        User::where('id', $id)
            ->update(['gold' => $gold]);
    }

    public function getUserVotes(Request $request)
    {
        $votes = Votes::where('voter', '=', $request['id'])->orderBy("created_at", "desc")->take(15)->get();
        $favorites = $this->getUserFavorites($request['id']);
        return [
            "votes" => $votes, "favorites" => [
                "game" => $favorites['game'],
                "streamer" => $favorites['streamer'],
            ]
        ];
    }

    public function getUserFavorites($id)
    {
        $favorites['game'] = Votes::select('name_voted', Votes::raw('count("name_voted") as votes'))->where('voter', $id)->where('type', 'game')->groupBy('name_voted')->orderByDesc('votes')->first() ? Votes::select('name_voted', Votes::raw('count("name_voted") as votes'))->where('voter', $id)->where('type', 'game')->groupBy('name_voted')->orderByDesc('votes')->first()->toArray()['name_voted'] : "";
        $favorites['streamer'] = Votes::select('name_voted', Votes::raw('count("name_voted") as votes'))->where('voter', $id)->where('type', 'streamer')->groupBy('name_voted')->orderByDesc('votes')->first() ? Votes::select('name_voted', Votes::raw('count("name_voted") as votes'))->where('voter', $id)->where('type', 'streamer')->groupBy('name_voted')->orderByDesc('votes')->first()->toArray()['name_voted'] : "";

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
