<?php

use App\Http\Controllers\api\V1\AuthController;
use App\Http\Controllers\api\V1\OrdersController;
use App\Http\Controllers\api\V1\ProductController;
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
Route::resource('order', OrdersController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
])->names([
    'index' => 'api.order.index',
    'store' => 'api.order.store',
    'show' => 'api.order.show',
    'update' => 'api.order.update',
    'destroy' => 'api.order.destroy',
]);

Route::resource('product', ProductController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
])->names([
    'index' => 'api.product.index',
    'store' => 'api.product.store',
    'show' => 'api.product.show',
    'update' => 'api.product.update',
    'destroy' => 'api.product.destroy',
]);

Route::get('product/{name}/brands-and-models', [ProductController::class, 'getAllBrandsAndModalsSelectedProduct']);

Route::post('login', [AuthController::class, 'login'])->name('api.login');
Route::post('register', [AuthController::class, 'register'])->name('api.register');
Route::get('logout', [AuthController::class, 'logout'])->name('api.logout');
Route::post('refresh', [AuthController::class,'refresh'])->name('api.refresh');
Route::get('getUser', [AuthController::class, 'getUser'])->name('api.getUser');

