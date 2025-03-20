<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\PostController;
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

    Route::get("/category", [CategoryController::class, 'index'])->middleware('auth:sanctum');
    Route::post("/category", [CategoryController::class, 'store'])->middleware('auth:sanctum');
    Route::post("/category/{id}", [CategoryController::class, 'update'])->middleware('auth:sanctum');
    Route::delete("/category/{id}", [CategoryController::class, 'destroy'])->middleware('auth:sanctum');

    Route::get("/post", [PostController::class, 'index'])->middleware("auth:sanctum");
    Route::get("/post/{id}", [PostController::class, 'show'])->middleware("auth:sanctum");
    Route::post("/post", [PostController::class, 'store'])->middleware("auth:sanctum");
    Route::post("/post/{id}", [PostController::class, 'update'])->middleware("auth:sanctum");
    Route::delete("/post/{id}", [PostController::class, 'destroy'])->middleware("auth:sanctum");
});
