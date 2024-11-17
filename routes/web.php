<?php

use App\Http\Controllers\AbsentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/verify/{token}', [AuthController::class, 'verify']);

// route middleware guest
Route::middleware(['guest'])->group(function () {

    // route auth
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginAction']);
    Route::get('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('forgot-password', [AuthController::class, 'forgotPasswordAction']);
    Route::get('reset-password/{token}', [AuthController::class, 'resetPassword']);
    Route::put('reset-password/{token}/action', [AuthController::class, 'resetPasswordAction']);

});


// route middleware auth
Route::middleware(['auth'])->group(function () {

    // route auth
    Route::get('logout', [AuthController::class, 'logout']);

    // grup backoffice
    Route::prefix('backoffice')->group(function () {

        // grup dashboard
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', [DashboardController::class, 'index']);
        });

        // grup office
        Route::group(['prefix' => 'office'], function () {
            Route::get('/', [OfficeController::class, 'index']);
            Route::post('/add', [OfficeController::class, 'add']);
            Route::post('/create', [OfficeController::class, 'create']);

            // grup office_id
            Route::group(['prefix' => '{office_id}'], function () {
                Route::put('/update', [OfficeController::class, 'update']);
                Route::put('/edit', [OfficeController::class, 'edit']);
                Route::put('/detail', [OfficeController::class, 'detail']);
                Route::get('/delete', [OfficeController::class, 'delete']);
            });
        });

        // grup absen
        Route::group(['prefix' => 'absen'], function () {
            Route::get('/create', [AbsentController::class, 'create']);
        });

        // grup absent
        Route::group(['prefix' => 'absent'], function () {
            Route::get('/', [AbsentController::class, 'index']);
            Route::get('/self', [AbsentController::class, 'self']);
            Route::post('/store', [AbsentController::class, 'store']);

            // grup absent_id
            Route::group(['prefix' => '{absent_id}'], function () {
                Route::get('/edit', [AbsentController::class, 'edit']);
                Route::put('/update', [AbsentController::class, 'update']);
                Route::get('/delete', [AbsentController::class, 'delete']);
                Route::get('/detail', [AbsentController::class, 'detail']);
            });
        });

        // grup user data
        Route::group(['prefix' => 'user-data'], function () {

            // grup role
            Route::group(['prefix' => 'role'], function () {
                Route::get('/', [RoleController::class, 'index']);
                Route::post('/create', [RoleController::class, 'create']);

                // grup role_id
                Route::group(['prefix' => '{role_id}'], function () {
                    Route::put('/update', [RoleController::class, 'update']);
                    Route::get('/delete', [RoleController::class, 'delete']);
                });

            });

            // grup user
            Route::group(['prefix' => 'user'], function () {
                Route::get('/', [UserController::class, 'index']);
                Route::post('/create', [UserController::class, 'create']);

                // grup user_id
                Route::group(['prefix' => '{user_id}'], function () {
                    Route::put('/update', [UserController::class, 'update']);
                    Route::get('/profile', [UserController::class, 'profile']);
                    Route::get('/edit-data', [UserController::class, 'editData']);
                    Route::get('/edit-password', [UserController::class, 'editPassword']);
                    Route::post('/update-data', [UserController::class, 'updateData']);
                    Route::post('/update-password', [UserController::class, 'updatePassword']);
                    Route::get('/delete', [UserController::class, 'delete']);
                });

            });

        });

        // grup absent data ------------------------------------------------------------
        Route::group(['prefix' => 'absent-data'], function () {

            // grup absent
            Route::group(['prefix' => 'absent'], function () {
                Route::get('/', [AbsentController::class, 'index']);
                Route::post('/create', [AbsentController::class, 'create']);

                // grup absent_id
                Route::group(['prefix' => '{absent_id}'], function () {
                    Route::put('/update', [AbsentController::class, 'update']);
                    Route::get('/delete', [AbsentController::class, 'delete']);
                });

            });

            // grup submission
            Route::group(['prefix' => 'submission'], function () {
                Route::get('/', [SubmissionController::class, 'index']);
                Route::post('/create', [SubmissionController::class, 'create']);

                // grup submission_id
                Route::group(['prefix' => '{submission_id}'], function () {
                    Route::put('/update', [SubmissionController::class, 'update']);
                    Route::get('/delete', [SubmissionController::class, 'delete']);
                });

            });
            
        });

        // grup shift
        Route::group(['prefix' => 'shift'], function () {
            Route::get('/', [ShiftController::class, 'index']);
            Route::post('/create', [ShiftController::class, 'create']);

            // grup shift_id
            Route::group(['prefix' => '{shift_id}'], function () {
                Route::put('/update', [ShiftController::class, 'update']);
                Route::get('/delete', [ShiftController::class, 'delete']);
            });

        });

        // grup master data
        Route::group(['prefix' => 'master-data'], function () {

            // grup division
            Route::group(['prefix' => 'division'], function () {
                Route::get('/', [DivisionController::class, 'index']);
                Route::post('/create', [DivisionController::class, 'create']);

                // grup division_id
                Route::group(['prefix' => '{division_id}'], function () {
                    Route::put('/update', [DivisionController::class, 'update']);
                    Route::get('/delete', [DivisionController::class, 'delete']);
                });

            });

            // grup position
            Route::group(['prefix' => 'position'], function () {
                Route::get('/', [PositionController::class, 'index']);
                Route::post('/create', [PositionController::class, 'create']);

                // grup position_id
                Route::group(['prefix' => '{position_id}'], function () {
                    Route::put('/update', [PositionController::class, 'update']);
                    Route::get('/delete', [PositionController::class, 'delete']);
                });

            });

            // grup shift
            Route::group(['prefix' => 'shift'], function () {
                Route::get('/', [ShiftController::class, 'index']);
                Route::post('/create', [ShiftController::class, 'create']);

                // grup shift_id
                Route::group(['prefix' => '{shift_id}'], function () {
                    Route::put('/update', [ShiftController::class, 'update']);
                    Route::get('/delete', [ShiftController::class, 'delete']);
                });

            });

        });
        
    });

});