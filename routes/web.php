<?php
use App\HTTP\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

// User Routes
Route::post('/register', [UserController::class, 'UserRegistration']);
Route::post('/login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class, 'SendOTPCode']);
Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);
Route::post('/reset-password', [UserController::class, 'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);

// User authenticated routes
Route::middleware([TokenVerificationMiddleware::class])->group(function () {
  Route::get('/user-profile', [UserController::class, 'UserProfile']);
  Route::post('/user-update', [UserController::class, 'UpdateProfile']);
  // Todo Routes
//   Route::apiResource('todos', TodoController::class);
});

Route::get('/logout', [UserController::class, 'UserLogout']);

// Todo Routes
Route::middleware([TokenVerificationMiddleware::class])->group(function () {
  Route::post('/todo-create', [TodoController::class, 'create']);
  Route::get('/todo-read', [TodoController::class, 'read']);
  Route::post('/todo-update/{id}', [TodoController::class, 'update']);
  Route::delete('/todo-delete/{id}', [TodoController::class, 'delete']);
});
