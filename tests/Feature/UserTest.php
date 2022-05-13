<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Testea el log in del usuario creado en el test de creación de usuario
     */
    public function test_login()
    {
        $response = $this->post('api/login', [
            'email' => 'test@test.com',
            'password' => 'Test1234@',
        ]);

        $response->assertStatus(200);
    }

    /**
     * Testea la edición de contraseñas
     */
    public function test_edit_password()
    {
        $id = User::where('email', 'test@test.com')->get()->toArray()[0]['id'];
        $response = $this->post('api/editUserData', [
            "id" => $id,
            "name" => "testEdited",
            "username" => "testEdited",
            "email" => "test@test.com",
            "gold" => "100",
        ]);
        $response->assertStatus(200);
    }

    /**
     * Testea los datos de usuario
     */
    public function test_edit_user_data()
    {
        $id = User::where('email', 'test@test.com')->get()->toArray()[0]['id'];
        $response = $this->post('api/editUserPassword', [
            'actual' => 'Test1234@',
            'new' => 'Test1235@',
            'new_confirmation' => 'Test1235@',
            'user_id' => $id,
        ]);
        $response->assertStatus(200);
    }

    /**
     * Testea la obtención de usuarios por su id
     */
    public function test_get_user_by_id()
    {
        $id = User::where('email', 'test@test.com')->get()->toArray()[0]['id'];
        $response = $this->post('api/getUserById', [
            'id' => $id,
        ]);
        $response->assertStatus(200);
    }

    /**
     * Testea la eliminación de usuario
     */
    public function test_delete_user()
    {
        $id = User::where('email', 'test@test.com')->get()->toArray()[0]['id'];
        $response = $this->post('api/deleteUserData', [
            'id' => $id,
        ]);
        $response->assertStatus(200);
    }
}
