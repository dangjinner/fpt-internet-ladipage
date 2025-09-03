<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FptInternetController;

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

Route::get('/', [FptInternetController::class, 'index'])->name('fpt.internet.index');

Route::get('/thank-you', [FptInternetController::class, 'thankYou'])->name('fpt.internet.thank-you');

Route::post('/register-service', [FptInternetController::class, 'registerService'])->name('fpt.internet.register');
