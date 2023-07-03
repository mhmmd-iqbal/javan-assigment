<?php

use App\Http\Controllers\PeopleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PeopleController::class, 'index']);
Route::get('/{id}', [PeopleController::class, 'show']);
Route::post('/store', [PeopleController::class, 'store']);
Route::delete('/delete/{id}', [PeopleController::class, 'destroy']);
Route::put('/update/{id}', [PeopleController::class, 'update']);
