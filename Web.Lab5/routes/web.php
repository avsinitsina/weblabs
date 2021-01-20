<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});
use App\Http\Controllers\RapperController;

Route::get('/', [RapperController::class, 'index']);
Route::post('list/{num}', [RapperController::class, 'list'])->whereNumber('num');
Route::get('create', [RapperController::class, 'form']);
Route::post('store', [RapperController::class, 'store']);
Route::post('store/{num}', [RapperController::class, 'store'])->whereNumber('num');
Route::post('delete/{num}', [RapperController::class, 'delete'])->whereNumber('num');
Route::get('edit/{num}', [RapperController::class, 'form'])->whereNumber('num');
Route::post('generate', [RapperController::class, 'generate']);
Route::get('random/{num}', [RapperController::class, 'random'])->whereNumber('num');
Route::get('random', [RapperController::class, 'random']);

//$routes->get('/', 'RapperController::index');
//$routes->post('/list/(:num)', 'RapperController::list/$1');
//$routes->get('create', 'RapperController::form');
//$routes->post('store', 'RapperController::store');
//$routes->post('store/(:num)', 'RapperController::store/$1');
//$routes->post('delete/(:num)', 'RapperController::delete/$1');
//$routes->get('edit/(:num)', 'RapperController::form/$1');
//$routes->post('generate', 'RapperController::generate');

//$routes->get('random/(:num)', 'RapperController::random/$1');
//$routes->get('random', 'RapperController::random');
