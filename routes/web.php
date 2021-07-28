<?php

use App\Http\Controllers\PropertiesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PropertiesController::class, 'index']);
Route::get('/property/load', [PropertiesController::class, 'loadFromApi']);
Route::get('/property/delete/{property}', [PropertiesController::class, 'delete']);
Route::get('/property/search', [PropertiesController::class, 'search']);
