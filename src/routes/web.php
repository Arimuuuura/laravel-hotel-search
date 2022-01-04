<?php

use App\Http\Controllers\HotelController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('result', [HotelController::class, 'index'])
    ->middleware(['auth'])->name('hotel.index');

Route::post('result/{query}', [HotelController::class, 'getArea'])
    ->middleware(['auth'])->name('hotel.getArea');

require __DIR__.'/auth.php';
