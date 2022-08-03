<?php

namespace App\Http\Controllers;
use App\Models\notification_token;
use App\Models\User;
use App\Models\user_role;
use App\Models\volunteer;
use App\Notifications\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|unique:users,name',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string',
            'notification_token'=>'required|string'
        ]);

        if ($validator->fails())
        return response()->json(
            $validator->errors()->toJson(), 400);

        $user = new User();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $token = $user->createToken('myapptoken')->plainTextToken;

    notification_token::create([
                    'user_id' => $user->id,
                    'token' => $request->notification_token,
                ]);
$user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token,
            'notification_token'=>$request->notification_token
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
            'name'     => 'required|string',
            'password' => 'required|string',

        ]);
//        Validator::make($request->all(), [
//            'toke'     => 'required|string',
//        ]);
        if ($login_data->fails()) {
            return response()->json([
                'message' => $login_data->errors()->getMessages(),
            ],400);
        }

        // Check email
        $user = User::where('name', $request->name)->first();
        $x = $user->is_verified;
        if ($x == false) {
            return response()->json([
                'message' => 'your email isn\'t verified',
            ], 403);
        }

        try {
            if (!auth()->attempt($login_data->validated())) {
                return response()->json([
                    'message' => 'Invalid Credentials',
                ], 403);

            }
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Bad creds',
            ], 403);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        //notification
        if($request->toke) {
            $tokens = notification_token::where('user_id', '=', $user->id)->get();
            $exists = false;
            foreach ($tokens as $tok) {
                if ($tok->token == $request->toke) {
                    $exists = true;
                }
            }
            if ($exists == false) {
                notification_token::create([
                    'user_id' => $user->id,
                    'token' => $request->toke,
                ]);
            }
        }
        $roles = DB::table('user_roles')
            ->select('roles.name')
            ->join('roles', 'roles.id', '=', 'user_roles.role_id')
            ->where('user_id', '=', auth()->user()->id)
            ->get();
        foreach ($roles as $role) {
            if ($role->name == 'leader') {
                $campaign = volunteer::where('user_id', '=', auth()->user()->id)->where('is_leader', '=', 1)
                    ->select('volunteer_campaign_id')->get();
                return response()->json([
                    'message' => 'User logged in Successfully',
                    'user' => $user,
                    'token' => $token,
                    'roles' => $roles,
                    'campaigns' => $campaign
                ], 200);
            }
        }

        $ro = DB::table('user_roles')
            ->select('roles.name')
            ->join('roles', 'roles.id', '=', 'user_roles.role_id')
            ->where('user_id', '=', auth()->user()->id)
            ->get();


        return response()->json([
            'message' => 'User logged in Successfully',
            'user' => $user,
            'token' => $token,
            'roles' => $ro
        ], 200);
    }



    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out'
        ],200);
    }

    //code



    public function register_code(Request $request){

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|unique:users,name',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string'
        ]);

        if ($validator->fails())
            return response()->json(
                $validator->errors()->toJson(), 400);

        $user = new User();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $token = $user->createToken('myapptoken')->plainTextToken;

        $user->generateCode();
        $user->notify(new VerificationCode());

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token
        ], 201);
    }
}


