<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Testea el log in, con credenciales correctas, del usuario creado en el test de creación de usuario
     */
    public function test_correct_login()
    {
        $response = $this->post('api/login', [
            'email' => 'test@test.com',
            'password' => 'Test1234@',
        ]);

        $response->assertStatus(200);
    }

    /**
     * Testea el log in, con email inexistente en la base de datos.
     */
    public function test_non_existent_email_login()
    {
        $response = $this->post('api/login', [
            'email' => 'testt@test.com',
            'password' => 'Test1234@',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The selected email is invalid.'
        ]);
    }

    /**
     * Testea el log in, con email existente y password incorrecta
     */
    public function test_incorrect_password_login()
    {
        $response = $this->post('api/login', [
            'email' => 'test@test.com',
            'password' => 'Test1234555@',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'password' => [
                        0 => 'Incorrect Password.'
                    ]
                ]
            ]);
    }

    /**
     * Testea deshabilitar o desactivar un usuario
     */
    public function test_disable_user()
    {
        $id = User::where('email', 'test@test.com')->get()->toArray()[0]['id'];
        $response = $this->post('api/disableUser', [
            "id" => $id,
        ]);
        $response->assertStatus(200);
    }

    /**
     * Testea el login de un usuario deshabilitado o no activo
     */
    public function test_disabled_user_login()
    {
        $response = $this->post('api/login', [
            'email' => 'test@test.com',
            'password' => 'Test1234@',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'disabled' => [
                        0 => 'The user is disabled.'
                    ]
                ]
            ]);
    }

    /**
     * Testea habilitar o activar un usuario
     */
    public function test_enable_user()
    {
        $id = User::where('email', 'test@test.com')->get()->toArray()[0]['id'];
        $response = $this->post('api/enableUser', [
            "id" => $id,
        ]);
        $response->assertStatus(200);
    }

    /**
     * Testea la edición de contraseñas con valores correctos
     */
    public function test_edit_password()
    {
        $id = User::where('email', 'test@test.com')->get()->toArray()[0]['id'];
        $response = $this->post('api/editUserPassword', [
            'actual_password' => 'Test1234@',
            'new_password' => 'Test1235@',
            'new_password_confirmation' => 'Test1235@',
            'user_id' => $id,
        ]);
        $response->assertStatus(200);
    }

    /**
     * Testea la edición de contraseñas cuando se le pasa la contraseña actual incorrecta
     */
    public function test_edit_password_incorrect_actual_password()
    {
        $id = User::where('email', 'test@test.com')->get()->toArray()[0]['id'];
        $response = $this->post('api/editUserPassword', [
            'actual_password' => 'Test1234@',
            'new_password' => 'Test1234@',
            'new_password_confirmation' => 'Test1234@',
            'user_id' => $id,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'Actual Password' => [
                        0 => 'The actual password is not correct.'
                    ]
                ]
            ]);
    }

    /**
     * Testea la edición de contraseñas cuando se le pasan contraseña actual y contraseña nueva iguales
     */
    public function test_edit_password_equal_actual_and_new_password()
    {
        $id = User::where('email', 'test@test.com')->get()->toArray()[0]['id'];
        $response = $this->post('api/editUserPassword', [
            'actual_password' => 'Test1234@',
            'new_password' => 'Test1234@',
            'new_password_confirmation' => 'Test1234@',
            'user_id' => $id,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'Actual Password' => [
                        0 => 'The actual password is not correct.'
                    ]
                ]
            ]);
    }

    /**
     * Testea la edición de contraseñas cuando se le pasan nueva contraseña y confirmación diferentes
     */
    public function test_edit_password_new_and_confirmation_dont_match()
    {
        $id = User::where('email', 'test@test.com')->get()->toArray()[0]['id'];
        $response = $this->post('api/editUserPassword', [
            'actual_password' => 'Test1235@',
            'new_password' => 'Test1235@',
            'new_password_confirmation' => 'Test12366@',
            'user_id' => $id,
        ]);
        $response->assertSessionHasErrors([
            'new_password' => 'The new password confirmation does not match.'
        ]);
    }

    /**
     * Testea los datos de usuario
     */
    public function test_edit_user_data()
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
