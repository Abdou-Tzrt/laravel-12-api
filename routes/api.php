<?php

use App\Http\Controllers\PostController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/profile', function(Request $request){
    return $request->user();
});

Route::post('/login', function(Request $request){
    $user = User::where('email', $request->email)->firstOrFail();
    $token = $user->createToken('auth_token')->plainTextToken;
    
    return response()->json(["access_token" => $token, "type_token" => "Bearer"]);

});

Route::middleware('throttle:custom')->get('/limited', function () {
    return 'You are not blocked (yet)';
});

Route::apiResource('posts', PostController::class);
