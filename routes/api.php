<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CommentsController;
use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes 
| Here is where you can register API routes for your application.
|--------------------------------------------------------------------------
*/


Route::group(["prefix" => "v1"], function () {

    Route::post("/register", [AuthController::class, "register"]);
    Route::post("/login", [AuthController::class, "login"]);

    Route::middleware("auth:sanctum")->group(function () {

        Route::post("/logout", [AuthController::class, "logout"]);

        Route::middleware("role:admin")->group(function () {
            Route::post('/category', [CategoryController::class, 'store']);
            Route::post('/category/{id}', [CategoryController::class, 'update']);
            Route::delete('/category/{id}', [CategoryController::class, 'destroy']);
        });

        Route::get('/category', [CategoryController::class, 'index']);

        Route::get("/post", [PostController::class, "index"]);
        Route::post("/post", [PostController::class, "store"]);
        Route::post("/post/{id}", [PostController::class, "update"]);
        Route::get("/post/{id}", [PostController::class, "show"]);
        Route::delete("/post/{id}", [PostController::class, "destroy"]);

        Route::post("/comment", [CommentsController::class, 'addCommentToPost']);
        Route::post("/comment/{id}", [CommentsController::class, 'update']);
        Route::delete("/comment/{id}", [CommentsController::class, 'destroy']);
    });
});
