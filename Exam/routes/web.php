<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/register/form/{id}', [HomeController::class, 'register_form'])->name('register_form.get');
Route::get('/applications', [HomeController::class, 'applications_show'])->name('applications.show');
Route::get('/employees', [HomeController::class, 'employees'])->name('employees.show');
Route::get('/add/task', [HomeController::class, 'add_task_form'])->name('add_task_form.show');
Route::get('/applications/create', [HomeController::class, 'applications_get'])->name('applications.get');
Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('edit');


Route::post('/applications', [HomeController::class, 'applications_post'])->name('applications.post');
Route::post('/create/employee', [HomeController::class, 'create_employee'])->name('create_employee.store');
Route::post('/create/task', [HomeController::class, 'create_task'])->name('task.store');

https://ru.stackoverflow.com/questions/1264545/Зачем-использовать-put-и-delete-methods-в-laravel-если-можно-get
Route::put('/update/{id}', [HomeController::class, 'update'])->name('update');


Route::delete('/task/delete/{id}', [HomeController::class, 'delete_task'])->name('task.delete');
Route::delete('/employee/delete/{id}', [HomeController::class, 'delete_employee'])->name('employee.delete');

Auth::routes();
