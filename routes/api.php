<?php

use App\Http\Controllers\Api\v1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::get("/tes", function () {
    return response()->json([
        "message" => "tes"
    ]);
});

Route::group(["prefix" => "v1"], function () {
    Route::post("/login", [AuthController::class, 'login']);
    Route::post("/register", [AuthController::class, 'register']);

    Route::post("/logout", [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
