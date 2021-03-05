<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoController;

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

Route::get('/', [CryptoController::class, 'login']);
Route::post('validarlogin', [CryptoController::class, 'validarlogin']);
Route::get('/addCarrito/{id_producto}', [CryptoController::class, 'addCarrito']);
Route::get('/deleteCarrito', [CryptoController::class, 'deleteCarrito']);
// Route::get('/mostrar_productos', [CryptoController::class, 'deleteCarrito']);
Route::get('/verCarrito', [RestauranteController::class, 'verCarrito']);