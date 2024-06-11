<?php

use App\Http\Controllers\SaveParcedReviewsController;
use App\Http\Controllers\SaveRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Services\Browser\BrowserServices;
use App\Http\Services\Browser\BrowserProfileServices;
use App\Http\Services\Craigslist\CraigslistServices;
use App\Models\AutoPost;

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

/*
Route::get('/', function () {
    return view('welcome');
});
*/


Route::redirect('', '/admin')->name('login');

