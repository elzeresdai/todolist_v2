<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;

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

Route::get('/todolist', [TodoListController::class, 'index']);
Route::post('/todolist', [TodoListController::class, 'store']);
Route::get('/todolist/{id}', [TodoListController::class, 'show']);
Route::put('/todolist/{id}', [TodoListController::class, 'update']);
Route::delete('/todolist/{id}', [TodoListController::class, 'destroy']);
Route::post('/todolist/{id}/enable-editing', [TodoListController::class, 'enableEditing']);
Route::post('/todolist/{id}/disable-editing', [TodoListController::class, 'disableEditing']);
