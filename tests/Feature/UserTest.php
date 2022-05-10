<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_user()
    {
        $user = User::where("email", "test@test.com")->get()->count();
        if(!$user){
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

    public function test_login()
    {

        $response = $this->post('api/login', [
            'email' => 'test@test.com',
            'password' => 'Test1234@',
        ]);

        $response->assertStatus(200);
    }
}
