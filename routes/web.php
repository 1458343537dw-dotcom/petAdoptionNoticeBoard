<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| 这里是应用程序的Web路由定义
|
*/

// 首页重定向到宠物列表
Route::get('/', function () {
    return redirect()->route('pets.index');
});

/*
|--------------------------------------------------------------------------
| 认证路由
|--------------------------------------------------------------------------
*/

// 显示登录表单
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login')
    ->middleware('guest');

// 处理登录请求
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

// 显示注册表单
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register')
    ->middleware('guest');

// 处理注册请求
Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest');

// 处理登出请求
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| 宠物资源路由
|--------------------------------------------------------------------------
*/

// 公开访问的宠物路由
Route::get('/pets', [PetController::class, 'index'])->name('pets.index');

// 需要认证的宠物路由（必须在 {pet} 参数路由之前定义）
Route::middleware('auth')->group(function () {
    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
    Route::get('/pets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');
    Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');
    
    // 我的宠物列表
    Route::get('/my-pets', [PetController::class, 'myPets'])->name('pets.my');
});

// 宠物详情（公开访问，必须在最后定义以避免路由冲突）
Route::get('/pets/{pet}', [PetController::class, 'show'])->name('pets.show');
