<?php

use Illuminate\Support\Facades\Route;

use function App\Helpers\test;
use function App\Helpers\twilio_env;

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
})->name('home');

Route::get('/contact', function () {
    return view('test.contact');
})->name('contact');
Route::get('/about-us', function () {
    return view('about');
});
