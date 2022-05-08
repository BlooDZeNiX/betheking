<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rules\Password;
use Laravel\Sanctum\NewAccessToken;

/**
 * Class AuthController
 *
 * @author  cmsf <cesarmsfelipe@gmail.com>
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);
        $data['last_login'] = Carbon::now()->toDateTimeString();

        /** @var \App\Models\User $user */
        $user = $this->createUser($data);


        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => [
                'required',
            ],
            'remember' => 'boolean'
        ]);
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'error' => 'The Provided credentials are not correct'
            ], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        User::where('id', $user->id)->update([
            'last_login' => Carbon::now()->toDateTimeString()]);
            $token = $user->createToken('token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }

    public function getUsers()
    {
        $users = User::all();
        return $users;
    }

    public function createUser($data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'active' => 1,
            'last_login' => 'now()',
            'deleted_at' => null,
            'imageUrl' => '../src/assets/images/betheking.png',
            'password' => bcrypt($data['password'])
        ]);

        return $user;
    }

    public function getUserbyId(Request $request)
    {
        $user = User::where('id', $request['id'])->get();
        return $user;
    }

    public function editUserImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jfif,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
        ]);
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move("../vue/src/assets/uploads", $fileName);
        $fileName = "../src/assets/uploads/" . $fileName;
        User::where("id", $request->id)->update(['imageUrl' => $fileName]);
        return response()->json([
            'success' => 'You have successfully upload file.',
            'fileName' => $fileName
        ]);
    }

    public function editUserData(Request $request)
    {
        if (isset($request['gold'])) {
           return User::where('id', $request['id'])
                ->update([
                    "name" => $request["name"],
                    "username" => $request["username"],
                    "email" => $request['email'],
                    "gold" => $request['gold'],
                ]);
        } else {
           return User::where('id', $request['id'])
                ->update([
                    "name" => $request["name"],
                    "username" => $request["username"],
                    "email" => $request['email'],
                ]);
        }
    }

    public function deleteUserData(Request $request)
    {
       return User::where('id', $request['id'])
            ->delete();
    }

    public function editUserPassword(Request $request)
    {

        $data = $request->validate([
            'new' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);
        /** @var \App\Models\User $user */
        $user =  User::where('id', $request['user_id'])->get();
        $user->makeVisible(['password']);

        if ((Hash::check($request['actual'], $user[0]['password']))) {
            if (($request['actual'] !== $request['new'])) {
                if ($request['new_confirmation'] === $request['new']) {
                    User::where('id', $request['user_id'])->update([
                        "password" => bcrypt($request['new'])
                    ]);
                }
            }
        } else {
            return 0;
        }
    }

    public function getTodayUsers()
    {
        $total = User::all()->count();
        $registered = User::whereDate('created_at', Carbon::today())->get()->count();
        $loged = User::whereDate('last_login', Carbon::today())->get()->count();
        return [
            "total" => $total,
            "registered" => $registered,
            "loged" => $loged,
        ];
    }
}
