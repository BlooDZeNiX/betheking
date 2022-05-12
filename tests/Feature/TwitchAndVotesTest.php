<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\User;
use App\Models\Games;
use App\Models\Streamers;
use App\Models\Votes;
use App\Models\GameVotes;
use App\Models\StreamVotes;


class TwitchTest extends TestCase
{
    public function test_create_user()
    {
        $user = User::where("email", "test@test.com")->get()->count();
        if (!$user) {
            User::factory()->create([
                'email' => 'test@test.com',
                'password' => bcrypt('Test1234@'),
                'username' => 'test',
                'rol' => 'user',
                'gold' => 0,
                'favorite_streamer' => '',
                'favorite_game' => '',
                'remember_token' => null,
                'active' => 1,
                'last_login' => null,
                'email_verified_at' => null,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ]);
        }

        $this->assertCount(1, User::where("email", "test@test.com")->get());
    }

    public function test_get_streamer()
    {
        $id = '36029255';
        $response = $this->post('api/getStreamer', ['id' => $id]);
        $response->assertJsonFragment([
            "broadcaster_type" => "partner",
            "display_name" => "Riot Games",
            "id_streamer" => 36029255,
        ]);
        $response->assertStatus(200);
    }

    public function test_get_game()
    {
        $id = '21779';
        $response = $this->post('api/getGame', ['id' => $id]);
        $response->assertJsonFragment([
            "name" => "League of Legends",
            "id_game" => 21779,
        ]);
        $response->assertStatus(200);
    }

    public function test_create_game()
    {
        Games::create([
            "id_game" => 112211111,
            'name' => 'testGame',
            "box_art_url" => "https://static-cdn.jtvnw.net/ttv-boxart/32399_IGDB-180x240.jpg",
            "created_at" => "2022-05-07T10:34:43.000000Z",
            "updated_at" => "2022-05-07T10:34:43.000000Z",
        ]);
        $response = $this->assertCount(1, Games::where("id_game", "112211111")->get());
    }

    public function test_create_streamer()
    {
        Streamers::create([
            "broadcaster_type" => "partner",
            "created_at" => "2022-05-11T161133.000000Z",
            "description" => "I",
            "display_name" => "test",
            "id_streamer" => 112211111,
            "offline_image_url" => "https://static-cdn.jtvnw.net/jtv_user_pictures/2f22a87d-f6df-4d11-af43-97b158751cfa-channel_offline_image-1920x1080.png",
            "profile_image_url" => "https://static-cdn.jtvnw.net/jtv_user_pictures/ad9d3702-8644-4172-9372-e90e7a0eeeff-profile_image-300x300.png",
            "updated_at" => "2022-05-11T16:11:33.000000Z",
        ]);
        $this->assertCount(1, Streamers::where("id_streamer", "112211111")->get());
    }

    public function test_vote_game()
    {
        $voter = User::where("email", "test@test.com")->get()->toArray()[0]['id'];
        $name = Games::where('id_game', '112211111')->get()->toArray()[0]['name'];
        $this->post('api/voteGame', ["voter" => $voter, "gameVoted" => "112211111", "name" => $name]);
        $this->assertCount(1, Votes::where("name_voted", $name)->get());
        $this->assertCount(1, GameVotes::where("game_voted", "112211111")->get());
    }

    public function test_vote_streamer()
    {
        $voter = User::where("email", "test@test.com")->get()->toArray()[0]['id'];
        $name = Streamers::where('id_streamer', '112211111')->get()->toArray()[0]['display_name'];
        $this->post('api/voteStreamer', ["voter" => $voter, "streamerVoted" => "112211111", "streamerLogin" => $name]);
        $this->assertCount(1, Votes::where("name_voted", $name)->get());
        $this->assertCount(1, StreamVotes::where("streamer_voted", "112211111")->get());
    }

    public function test_delete_game_and_votes()
    {
        $name = Games::where('id_game', '112211111')->get()->toArray()[0]['name'];
        $this->post('api/deleteGame', ["name" => $name, "id" => '112211111']);
        $this->assertCount(0, Games::where("id_game", "112211111")->get());
        $this->assertCount(0, GameVotes::where("game_voted", "112211111")->get());
        $this->assertCount(0, Votes::where("name_voted", $name)->get());
    }

    public function test_delete_streamer_and_votes()
    {
        $name = Streamers::where('id_streamer', '112211111')->get()->toArray()[0]['display_name'];
        $this->post('api/deleteStreamer', ["name" => $name, "id" => '112211111']);
        $this->assertCount(0, Streamers::where("id_streamer", "112211111")->get());
        $this->assertCount(0, StreamVotes::where("streamer_voted", "112211111")->get());
        $this->assertCount(0, Votes::where("name_voted", $name)->get());
    }
}
