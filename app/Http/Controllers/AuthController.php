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
        return response()->json(
            $validator->errors()->toJson(), 400);

        $fields = $request->validate([
            'email'    => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = new User();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $token = $user->createToken('myapptoken')->plainTextToken;
        //$user->sendEmailVerificationNotification();


        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token
        ], 201);

    }
    

    public function deleteAccount(Request $request){

        if(DB::table('users')->delete($request->user()))
            return $this->noContentResponse('deleted');
        else
            return $this->noContentResponse('nothing to delete');
    }
    


    public function login(Request $request) {
        
        // Validation
        $login_data = Validator::make($request->all(), [
            'name'     => 'required|string',
            'password' => 'required|string'
        ]);

        if ($login_data->fails()) {
            return response()->json([
                'message' => '$login_data->errors()->getMessages()',
            ],400);
        }
            
        // Check email
        $user = User::where('name', $request->name)->first();
        // if($user->is_verified==false){
        //     return response()->json([
        //         'message' => 'your email isn\'t verified',
        //     ],403);
        // }

        // try {
        //     if (!auth()->attempt($login_data->validated())) {
        //         return response()->json([
        //             'message' => 'Invalid Credentials',
        //         ],403);

        //     }
        // } catch (ValidationException $e) {
        //     return response()->json([
        //         'message' => 'Bad creds',
        //     ],403);
        // }


        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([
            'message' => 'User logged in Successfully',
            'user'  => $user,
            'token' => $token
        ]);
    }

    
    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return $this->noContentResponse('Logged out');
    }
}

