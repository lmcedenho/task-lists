<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskListController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//TO-DO protect and test routes with sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::resource('task-lists', TaskListController::class)->only([
        'store', 'update'
    ]);
});
