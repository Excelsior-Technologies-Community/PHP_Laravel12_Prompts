<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Redirect root to task index
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Task resource routes (index, create, store, show, edit, update, destroy)
Route::resource('tasks', TaskController::class);

// Custom status and featured toggle routes
Route::get('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggle-status');
Route::get('/tasks/{task}/toggle-featured', [TaskController::class, 'toggleFeatured'])->name('tasks.toggle-featured');

// Bulk delete route for selected tasks
Route::post('/tasks/bulk-delete', [TaskController::class, 'bulkDelete'])->name('tasks.bulkDelete');