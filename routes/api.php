<?php

use App\Http\Controllers\TaskController;
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

Route::prefix('todolist')->group(function () {
    Route::get('/', [TodoListController::class, 'index'])->name('todolist.index');
    Route::post('/', [TodoListController::class, 'store'])->name('todolist.store');
    Route::get('/{id}', [TodoListController::class, 'show'])->name('todolist.show');
    Route::put('/{id}', [TodoListController::class, 'update'])->name('todolist.update');
    Route::delete('/{id}', [TodoListController::class, 'destroy'])->name('todolist.destroy');
    Route::patch('/{id}/enable-editing', [TodoListController::class, 'enableEditing'])->name('todolist.enable-editing');
    Route::patch('/{id}/disable-editing', [TodoListController::class, 'disableEditing'])->name('todolist.disable-editing');
});

Route::prefix('tasks')->group(function () {
    Route::post('/', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::put('/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
    Route::put('/{task}/uncomplete', [TaskController::class, 'uncomplete'])->name('tasks.uncomplete');
    Route::get('/{task}/todolist', [TaskController::class, 'getTodoList'])->name('tasks.todolist');
});
