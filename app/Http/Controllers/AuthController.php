<?php

namespace App\Http\Controllers;
use App\Http\Controllers\EmailVerificationController;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\Types\Boolean;

class AuthController extends Controller
{
    use ApiResponder;

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'email'    => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        if ($validator->fails())
            return $this->errorResponse($validator->getMessageBag());

        $fields = $request->validate([
            'email'    => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user'  => $user,
            'token' => $token,
        ];
        $user->sendEmailVerificationNotification();
        return $this->okResponse($response,'User Register Successfully');
    }
    public function deleteAccount(Request $request){
        DB::table('users')->delete($request->user());
        return $this->noContentResponse('deleted');
    }
    public function login(Request $request) {

        // Validation
        $login_data = Validator::make($request->all(), [
            'name'    => 'required|string',
            'password' => 'required|string'
        ]);

        if ($login_data->fails()) {
            return $this->errorResponse($login_data->errors()->getMessages());
        }


        // Check email
        $user = User::where('name', $request->name)->first();

        // validate User data
        try {
            if (!auth()->attempt($login_data->validated())) {
                return $this->forbiddenResponse('Invalid Credentials');
            }
        } catch (ValidationException $e) {
            return $this->notFoundResponse('Bad creds');
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user'  => $user,
            'token' => $token
        ];

        return $this-> okResponse($response,'User logged in Successfully');

    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return $this->noContentResponse('Logged out');
    }
}

