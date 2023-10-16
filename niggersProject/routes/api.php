<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FirstController;
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

Route::post('/employeeCreate',[EmployeeController::class,'create']);
Route::get('/employeeRead',[EmployeeController::class,'read']);
Route::post('/employeeUpdate',[EmployeeController::class,'update']);
Route::delete('/employeeDelete/{id}',[EmployeeController::class,'delete']);
Route::get('/employeeSearch',[EmployeeController::class,'search']);
