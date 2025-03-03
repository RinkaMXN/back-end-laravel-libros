<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get("/index", [App\Http\Controllers\BooksController::class, "index"])->name("index");
Route::get("/getAutoresAll", [App\Http\Controllers\BooksController::class, "getAutoresAll"])->name("getAutoresAll");
Route::get("/getGenerosAll", [App\Http\Controllers\BooksController::class, "getGenerosAll"])->name("getGenerosAll");
Route::post("/createbook", [App\Http\Controllers\BooksController::class, "createbook"])->name("createbook");
Route::get('/getBookById/{id}', [App\Http\Controllers\BooksController::class, 'getBookById']);
Route::post("/updatebook/{id}", [App\Http\Controllers\BooksController::class, "updatebook"])->name("updatebook");
