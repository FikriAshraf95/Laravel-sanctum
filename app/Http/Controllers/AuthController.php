<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function register(Request $request){

    $fields = $request->validate([
      'name' => 'required|string',
      'email' => 'required|string|unique:users,email',
      'password' => 'required|string|confirmed'
    ]);

    $user = User::create([
      'name'=>$fields['name'],
      'email'=>$fields['email'],
      'password'=>bcrypt($fields['password'])
    ]);

    $token = $user->createToken('myapptoken')->plainTextToken;

    $response = [
      'user' => $user,
      'token' => $token
    ];

    return response($response, 201);
  }

  public function login(Request $request){

    $fields = $request->validate([
      'email' => 'required|string',
      'password' => 'required|string'
    ]);

    // Check e-Mail
    $user = User::where('email', $fields['email'])->first();

    // Check password
    if(!$user || !Hash::check($fields['password'], $user->password)){
      return response([
        'message'=>'Bad creds'
      ],401);
    }

    $token = $user->createToken('myapptoken')->plainTextToken;

    $response = [
      'user' => $user,
      'token' => $token
    ];

    return response($response, 201);
  }

  public function logout(Request $request){
    auth()->user()->tokens()->delete();

    return[
      'message'=>'Logout'
    ];
  }

  // ======================================== For Web App

  public function index(){
    return view('auth.register');
  }

  public function store(Request $request){
    // dd('abc');
    // dd($request->only('email','password'));

    $fields = $request->validate([
      'name' => 'required|string',
      'username' => 'required|string',
      'email' => 'required|string|unique:users,email',
      'password' => 'required|string|confirmed'
    ]);

    $user = User::create([
      'name'=>$fields['name'],
      'username'=>$fields['username'],
      'email'=>$fields['email'],
      'password'=>bcrypt($fields['password'])
    ]);

    auth()->attempt($request->only('email','password'));

    return redirect()->route('dashboard');

    // $token = $user->createToken('myapptoken')->plainTextToken;
    //
    // $response = [
    //   'user' => $user,
    //   'token' => $token
    // ];
  }

}
