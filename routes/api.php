<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', fn (Request $request) => $request->user());

// Route::get('/groups', \App\Http\Controllers\IndexGroupController::class);
// Route::post('/groups', \App\Http\Controllers\StoreGroupController::class);
//
Route::prefix('/groups')
    ->controller(App\Http\Controllers\GroupController::class)
    ->group(function (): void {
        Route::get('/', 'index')->name('group-index');
        Route::get('/{group}', 'show')->name('group-show');
    });

Route::prefix('/groups')
    ->controller(App\Http\Controllers\GroupAdminController::class)
    ->group(static function (): void {
        Route::post('/admins', 'store')->name('create-group');
        Route::get('/{group}/admins/{admin}', 'pending')->name('pending-request');
        Route::post('/{group}/admins/{admin}/members/{member}/accept', 'accept')->name('accept-request');
        Route::post('/{group}/admins/{admin}/members/{member}/decline', 'decline')->name('decline-request');
        Route::post('/{group}/admins/{admin}/delete', 'delete')->name('delete-group');
    });

Route::prefix('/groups/{group}/members')
    ->controller(App\Http\Controllers\GroupMemberController::class)
    ->group(static function (): void {
        Route::post('/{member}', 'store')->name('join-request');
        Route::post('/{member}/withdraw', 'withdraw')->name('withdraw-request');
        Route::post('/{member}/leave', 'leave')->name('leave-group');
    });
