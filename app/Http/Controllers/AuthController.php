<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
            'name'     => 'required|string',
            'email'    => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        $user1 = new User();
        $user1->name = $request->name;
        $user1->description = $request->description ?? '';
        $user1->email = $request->email;
        $user1->password = bcrypt($request->password);
        $user1->save();

        $user1 = User::create([
            'name'     => $fields['name'],
            'email'    => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user1->createToken('myapptoken')->plainTextToken;

        $response = [
            'user'  => $user1,
            'token' => $token
        ];

        return $this->createdResponse($response,'User Register Successfully');
        // return response($response, 201);
    }

    public function login(Request $request) {

        // Validation
        $login_data = Validator::make($request->all(), [
            'email'    => 'required|string',
            'password' => 'required|string'
        ]);

        if ($login_data->fails()) {
            return $this->errorResponse($login_data->errors()->getMessages());
        }

        // $fields = $request->validate([
        //     'email' => 'required|string',
        //     'password' => 'required|string'
        // ]);

        // Check email
        $user = User::where('email', $request->email)->first();


        // validate User data
        try {
            if (!auth()->attempt($login_data->validated())) {
                return $this->forbiddenResponse('Invalid Credentials');
            }
        } catch (ValidationException $e) {
            return $this->notFoundResponse('Bad creds');
        }

        // // Check password
        // if(!$user || !Hash::check($fields['password'], $user->password)) {
        //     return response([
        //         'message' => 'Bad creds'
        //     ], 401);
        // }

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
        // return [
        //     'message' => 'Logged out'
        // ];
    }
}
