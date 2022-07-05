<?php

namespace App\Http\Controllers;
use App\Http\Controllers\EmailVerificationController;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\user_role;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\Types\Boolean;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|unique:users,name',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);
//            return $this->errorResponse($validator->getMessageBag());

        $fields = $request->validate([
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $token = $user->createToken('myapptoken')->plainTextToken;
        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token
        ], 201);
    }
    public function deleteAccount(Request $request){
        if(User::where('id',auth()->user()->id)->delete())
            return response()->json([
                'message' => 'deleted'
            ]);
        else
            return response()->json([
            'message' => 'nothing to delete'
            ],402);
    }
    public function login(Request $request) {

        // Validation
        $login_data = Validator::make($request->all(), [
            'name'    => 'required|string',
            'password' => 'required|string'
        ]);

        if ($login_data->fails()) {
//            return $this->errorResponse($login_data->errors()->getMessages());
            return response()->json([
                'message' => '$login_data->errors()->getMessages()',

            ],400);
        }


        // Check email
        $user = User::where('name', $request->name)->first();
        if($user->is_verified==false)
        {
            return response()->json([
                'message' => 'your email isn\'t verified',
            ],403);

        }
        // validate User data
        try {
            if (!auth()->attempt($login_data->validated())) {
                return response()->json([
                    'message' => 'Invalid Credentials',
                ],403);

            }
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Bad creds',
            ],403);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $user_role=user_role::select('role_id')->where('user_id','=',auth()->user()->id)->get();
        $user_role=$user_role->toArray();
        $arr=[];
        foreach ($user_role as $x)
        {
            $per=Role::where('id','=',$x)->first();
            array_push($arr,$per->Permissions()->get());
        }
        return response()->json([
            'message' => 'User logged in Successfully',
            'user'  => $user,
            'token' => $token,
            'per'=> $arr
        ],200);

    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
        return $this->noContentResponse('Logged out');
    }
}

