<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Streams;
use App\Models\Streamers;
use App\Models\Games;
use App\Models\StreamVotes;
use App\Models\Votes;
use App\Models\GameVotes;
use Brick\Math\BigInteger;
use Illuminate\Support\Facades\Http;

/**
 * Class TwitchController
 *
 * @author  cmsf <cesarmsfelipe@gmail.com>
 * @package App\Http\Controllers
 */
class TwitchController extends Controller
{
    //Credentials to authorization in calls to twitch api
    protected $headers = [
        'Authorization' => "Bearer ch7qkg7j4z43zhmqrpls1omsn5nmqt",
        "Client-id" => "xd72gmt643nbmegt9990z4c4iuvmc1"
    ];
    /**
     * Function to get the 100 top Streams with most viewers from twitch.tv
     *
     * @return JSON top Streams
     */
    public function getTopStreams()
    {
        $data = Http::withHeaders($this->headers)
            ->get("https://api.twitch.tv/helix/streams?first=100");
        $data = $data->json();
        $response = $data['data'];
        foreach ($response as $key => $value) {
            $response[$key]['thumbnail_url'] = str_replace("{width}", "262", $response[$key]['thumbnail_url']);
            $response[$key]['thumbnail_url'] = str_replace("{height}", "147", $response[$key]['thumbnail_url']);
            $this->setStream($value);
        }
        return $response;
    }

    /**
     * Get All streamers in database
     *
     * @return Array all streamers
     */
    public function getStreamers()
    {
        $streamers = Streamers::all();
        return $streamers;
    }

    /**
     * Function to insert a stream in database
     *
     * @param [Array] stream's data
     * @return Boolean
     */
    public function setStream($data)
    {
        /** @var \App\Models\Streams $stream */
        $stream = Streams::where('user_login', $data['user_login'])->first();
        if (!$stream) {
            Streams::create([
                'id_streamer' => $data['id'],
                'language' => $data['language'],
                'source' => 'Twitch',
                'user_login' => $data['user_login'],
                'user_name' => $data['user_name'],
                'url' => 'https://twitch.tv/' . $data['user_login'],
            ]);
        }
    }

    /**
     * Function to get an streamer from database by ID
     *
     * @param Request streamer's ID
     * @return Boolean
     */
    public function getStreamer(Request $request)
    {
        $id = $request->all();
        $data = Http::withHeaders($this->headers)
            ->get("https://api.twitch.tv/helix/users?id=" . $id['id']);
        $data = $data->json();
        return $this->setStreamer($data, $id['id']);
    }

    /**
     * Function to insert an streamer into database
     *
     * @param [Array] streamer's data
     * @param [String] streamer's id
     * @return Array Streamer's data
     */
    public function setStreamer($data, $id)
    {
        /** @var \App\Models\Streamers $streamer */
        $streamer = Streamers::where('id_streamer', $id)->first();
        if (!$streamer) {
            $streamer =  Streamers::create([
                'id_streamer' => $id,
                'broadcaster_type' => $data['data'][0]['broadcaster_type'],
                'description' => $data['data'][0]['description'],
                'display_name' => $data['data'][0]['display_name'],
                'offline_image_url' => $data['data'][0]['offline_image_url'],
                'profile_image_url' => $data['data'][0]['profile_image_url'],
            ]);
        }
        return $streamer;
    }

    /**
     * Function to delete an streamer from database and all its votes
     *
     * @param Request streamer's id
     * @return Boolean
     */
    public function deleteStreamer(Request $request)
    {
        StreamVotes::where('streamer_voted', $request['id'])->delete();
        Votes::where('name_voted', $request['name'])->delete();
        Streamers::where('id_streamer', $request['id'])
            ->delete();
    }

    /**
     * Function to get the 100 top Games with most viewers from twitch.tv
     *
     * @return JSON top Games
     */
    public function getTopGames()
    {
        $data = Http::withHeaders($this->headers)
            ->get("https://api.twitch.tv/helix/games/top?first=100");
        $data = $data->json();
        $response = $data['data'];
        foreach ($response as $key => $value) {
            $response[$key]['box_art_url'] = str_replace("{width}", "180", $response[$key]['box_art_url']);
            $response[$key]['box_art_url'] = str_replace("{height}", "240", $response[$key]['box_art_url']);
            $this->setGame($response[$key]);
        }

        return $response;
    }

    /**
     * Function to insert a Game in the database
     *
     * @param [Array] Game's data
     * @return Boolean
     */
    public function setGame($data)
    {
        /** @var \App\Models\Games $Game */
        $game = Games::where('id_game', $data['id'])->first();
        if (!$game) {
            Games::create([
                'id_game' => $data['id'],
                'box_art_url' => $data['box_art_url'],
                'name' => $data['name'],
            ]);
        }
    }

    /**
     * Function to get a game info by its ID
     *
     * @param Request game's id
     * @return Array game's info
     */
    public function getGame(Request $request)
    {
        $id = $request->all();
        $game = Games::where('id_game', '=', $id['id'])->get();
        return $game;
    }

    /**
     * Function to get all games in the database
     *
     * @return Array all games
     */
    public function getGames()
    {
        $games = Games::all();
        return $games;
    }

    /**
     * Function to delete a game from the database
     *
     * @param Request game's id
     * @return Boolean
     */
    public function deleteGame(Request $request)
    {
        GameVotes::where('game_voted', $request['id'])->delete();
        Votes::where('name_voted', $request['name'])->delete();
        Games::where('id_game', $request['id'])
            ->delete();
    }
}
