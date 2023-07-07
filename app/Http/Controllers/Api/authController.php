<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreuserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class authController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 
 
 
  
     public function register(StoreuserRequest $request)
     {

$user=new User();
$user->Name=$request->Name;
$user->email=$request->email;
$user->password=\Hash ::make( $request->password);
$user->Phone_number=$request->Phone_number;
$user->save();    
$token =  $user->createToken($request->Name)->plainTextToken; 
return new UserResource([$user,$token]);
// return Response(['token' => $success,'user'=>$user],200);
    // $token = $request->user()->createToken($request->token_name) 

        
     }

     public function login(Request $request)
    {
if(\Auth::attempt($request->only('email','password'))){
    //  return \Auth::user();
    $token =  \Auth::user()->createToken($request->email)->plainTextToken; 
    // event(new login(User::find(\Auth::user()->id))); 
return new UserResource([\Auth::user(),$token]);
}
else{
    return "not valied";
}}

     public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
