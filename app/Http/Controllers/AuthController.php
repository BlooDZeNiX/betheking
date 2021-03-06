<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rules\Password;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Laravel\Sanctum\NewAccessToken;

/**
 * Class AuthController
 *
 * @author  cmsf <cesarmsfelipe@gmail.com>
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Function to register an user in the database
     *
     * @param Request User data from form
     * @return [$user, $token]
     */
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
        $data['imageUrl'] = 'assets/images/betheking.png';
        /** @var \App\Models\User $user */
        $user = $this->createUser($data);


        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function addUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => [
                'required',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);

        $user = User::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),

        ]);
        return $user;

    }

    /**
     * Function to login in the website
     *
     * @param Request email and password
     * @return [$user, $token]
     */
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
                "errors" => [
                    'password' => [0 => 'Incorrect Password.']
                ]
            ], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->active) {
            return response([
                "errors" => [
                    'disabled' => [0 => 'The user is disabled.']
                ]
            ], 422);
        }

        User::where('id', $user->id)->update([
            'last_login' => Carbon::now()->toDateTimeString()
        ]);
        $token = $user->createToken('token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Function to log out the website
     *
     * @return true
     */
    public function logout()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }

    /**
     * Function to get all user in the database
     *
     * @return $users
     */
    public function getUsers()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Function that creates an user in the database
     *
     * @param [Array] $data #data of user
     * @return $user
     */
    public function createUser($data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'active' => 1,
            'last_login' => Carbon::now()->toDateTimeString(),
            'deleted_at' => null,
            'imageUrl' => '/public/avatar.png',
            'password' => bcrypt($data['password'])
        ]);

        return $user;
    }

    /**
     * Function to get an user by his ID
     *
     * @param Request id
     * @return $user
     */
    public function getUserbyId(Request $request)
    {
        $user = User::where('id', $request['id'])->get();
        return $user;
    }

    /**
     * Function to change the image of the user
     *
     * @param Request new Image
     * @return ['success' => 'You have successfully upload file.', 'fileName' => $relativePath]
     */
    public function editUserImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jfif,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
        ]);
        $dir = 'images/';
        $fileName = time() . '_' . $request->file->getClientOriginalName();
        $absolutePath = public_path($dir);
        $relativePath = $dir . $fileName;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        $request->file->move($absolutePath, $fileName);

        User::where("id", $request->id)->update(['imageUrl' => 'https://api.betheking.online/images/' . $fileName]);
        return response()->json([
            'success' => 'You have successfully upload file.',
            'fileName' => "https://api.betheking.online/images/" . $fileName,
        ]);
    }

    /**
     * Function to edit user's data
     *
     * @param Request user's data
     * @return Boolean
     */
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

    /**
     * Function to disable an user
     *
     * @param Request user's ID
     * @return Boolean
     */
    public function disableUser(Request $request)
    {
        // return $request;
        return User::where('id', $request['id'])
            ->update([
                "active" => '0',
            ]);
    }

    /**
     * Function to enable an user
     *
     * @param Request user's ID
     * @return Boolean
     */
    public function enableUser(Request $request)
    {
        // return $request;
        return User::where('id', $request['id'])
            ->update([
                "active" => '1',
            ]);
    }

    /**
     * Function to delete an user from database
     *
     * @param Request user's ID
     * @return Boolean
     */
    public function deleteUserData(Request $request)
    {
        return User::where('id', $request['id'])
            ->delete();
    }

    /**
     * Function to edit user's password
     *
     * @param Request ["actualpassword", "newpassword", "newpasswordconfirmation"]
     * @return Boolean
     */
    public function editUserPassword(Request $request)
    {
        $request->validate([
            'actual_password' => [
                'required',
                Password::min(8)->mixedCase()->numbers()->symbols(),
                // Hash::check($request['actual_password'], $user[0]['password'])
            ],
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);
        /** @var \App\Models\User $user */
        $user =  User::where('id', $request['user_id'])->get();
        $user->makeVisible(['password']);
        if ((Hash::check($request['actual_password'], $user[0]['password']))) {
            if (($request['actual_password'] !== $request['new_password'])) {
                if ($request['new_password_confirmation'] === $request['new_password']) {
                   $user = User::where('id', $request['user_id'])->update([
                        "password" => bcrypt($request['new_password'])
                    ]);
                    return User::where('id', $request['user_id'])->get();
                } else {
                    return response([
                        "errors" => [
                            'New Password' => [0 => 'The new password confirmation does not match.']
                        ]
                    ], 422);
                }
            } else {
                return response([
                    "errors" => [
                        'Actual Password' => [0 => 'The actual password and new password cannot be equals.']
                    ]
                ], 422);
            }
        } else {
            return response([
                "errors" => [
                    'Actual Password' => [0 => 'The actual password is not correct.']
                ]
            ], 422);
        }
    }

    public function verifyEmail(Request $request)
    {
        try {
            $mail = new PHPMailer;
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'btk@betheking.online';
            $mail->Password = 'Fraternidad0=';
            $mail->SMTPSecure = "tls";
            $mail->Port = 465;
            $mail->setFrom('btk@betheking.online', 'BeTheKing');
            $mail->addAddress($request['email'], $request['username']);
            $mail->isHTML(true);
            $mail->Body = "done";
            $mail->Subject = 'email Verification - BeTheking';
            $mail->send();
        } catch (Exception $e) {
            return $e;
        }
    }
    /**
     * Function to get total users, registered today and logged today
     *
     * @return ["total" => $total,"registered" => $registered,"loged" => $loged,]
     */
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
