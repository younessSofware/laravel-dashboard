<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SocialRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //socialLogin
    public function socialLogin(SocialRequest $request){
        $user = User::where('email', 'like', $request->email)->first();
        if($user){
            //social login
            $user->providerId = $request->providerId;
            $user->providerType = 'google';
            $token = $user->createToken('myAppToken')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response($response, 201);
        }else{
            // new account;
            $user = new User();
            $user->email = $request->email;
            $user->name = $request->name;
            $user->password = bcrypt($request->providerId);
            $user->providerType =$request->providerType;
            $user->providerId =$request->providerId;
            $user->role = 1;
            $user->save();
            $token = $user->createToken('myAppToken')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
                'newAccount' => true
            ];
            return response($response, 201);
        }
        return $request;
    }


    //Login
    public function login(LoginRequest $request){

        $user = User::where('email', $request['email'])->first();

        if(!$user || !Hash::check($request['password'], $user->password )){
            return response([
                'message'=> 'كلمة المرور او البريد الالكتروني خاطئ',
            ], 401);
        }
        $token = $user->createToken('myAppToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function storeAdmin(RegisterRequest $request){
        // return [$request['password'], bcrypt($request['password'])];
        $user = new User($request->all());
        $user->role = 0;
        $user->password = bcrypt($request['password']);
        // $token = $user->createToken('myAppToken')->plainTextToken;

        $user->save();
        $response = [
            'user' => $user,
        ];

        return response($response, 201);
    }

    //store
    public function store(RegisterRequest $request){
        // return [$request['password'], bcrypt($request['password'])];
        $user = new User($request->all());
        $user->password = bcrypt($request['password']);
        // $token = $user->createToken('myAppToken')->plainTextToken;

        $user->save();
        $response = [
            'user' => $user,
        ];

        return response($response, 201);
    }


    public function index(Request $request){
        $querySearch = '';
        $queries = $request->query();
        if(isset($queries['searchQuery'])){
            $querySearch = $queries['searchQuery'];
            return response(['data' => User::where('role', 'like', 1)->where('email', 'like', '%'.$querySearch.'%')->skip($queries['skip'])->take($queries['take'])->paginate($queries['take'])]);
        }
        return response(['data' => User::where('role', 'like', 1)->skip($queries['skip'])->take($queries['take'])->paginate($queries['take'])]);
    }

    public function indexAdmin(Request $request){
        $querySearch = '';
        $queries = $request->query();
        if(isset($queries['searchQuery'])){
            $querySearch = $queries['searchQuery'];
            return response(['data' => User::where('id', '!=', auth()->user()->id )->where('role', 'like', 0)->where('email', 'like', '%'.$querySearch.'%')->skip($queries['skip'])->take($queries['take'])->paginate($queries['take'])]);
        }
        return response(['data' => User::where('id', '!=', auth()->user()->id )->where('role', 'like', 0)->skip($queries['skip'])->take($queries['take'])->paginate($queries['take'])]);
    }

    public function show($id){
        return User::find($id);
    }

    public function enable($id){
        $user = User::find($id);
        if($user->active){
            $user->active = 0;
        }else $user->active = 1;
        $user->save();
        return [
            'message' => 'enabled correctly'
        ];
    }

    public function update(Request $request, $id){
        $user =  User::find($id);
        $user->name = $request->name;

        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->sexe = $request['sexe'];
        return $user->save();
    }

    public function destroy($id){
        $user = User :: find($id);
        $user->delete();
        return response(['message'=> 'delete correctly', 'status' => 200]);
    }

    public function profile(){
        return User::find(auth()->user()->id);
    }


    public function logout(Request $req){
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
