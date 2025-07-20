<?php

use App\Http\Controllers\AbsentController;
use App\Http\Controllers\AssesmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\MeetController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceSummaryController;
use App\Http\Controllers\LeaveQuotaController;
use Illuminate\Support\Facades\Route;

Route::get('/verify/{token}', [AuthController::class, 'verify']);
Route::get('/meetings/update-status', [MeetController::class, 'updateMeetingStatus'])->name('meetings.updateStatus');

// route middleware guest
Route::middleware(['guest'])->group(function () {

    // route auth
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginAction'])->name('login.action');
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
                Route::get('/detail', [OfficeController::class, 'detail']);
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

        // grup task
        Route::group(['prefix' => 'task'], function () {
            Route::get('/', [TaskController::class, 'index']);
            Route::post('/create', [TaskController::class, 'create']);

            // grup task_id
            Route::group(['prefix' => '{task_id}'], function () {
                Route::put('/update', [TaskController::class, 'update']);
                Route::get('/delete', [TaskController::class, 'delete']);
                Route::get('/delete-file', [TaskController::class, 'deleteFile']);
                Route::get('/preview', [TaskController::class, 'preview']);
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
                    Route::put('/update-by-admin', [UserController::class, 'updateByAdmin']);
                    Route::get('/profile', [UserController::class, 'profile']);
                    Route::get('/edit-data', [UserController::class, 'editData']);
                    Route::get('/edit-password', [UserController::class, 'editPassword']);
                    Route::post('/update-data', [UserController::class, 'updateData']);
                    Route::post('/update-password', [UserController::class, 'updatePassword']);
                    Route::get('/delete', [UserController::class, 'delete']);
                });

            });

        });

        // grup assesment
        Route::group(['prefix' => 'assesment-data'], function () {
            
            // grup criteria
            Route::group(['prefix' => 'criteria'], function () {
                Route::get('/', [CriteriaController::class, 'index']);
                Route::post('/create', [CriteriaController::class, 'create']);

                // grup criteria_id
                Route::group(['prefix' => '{criteria_id}'], function () {
                    Route::put('/update', [CriteriaController::class, 'update']);
                    Route::get('/delete', [CriteriaController::class, 'delete']);
                });
            });

            // grup assesment
            Route::group(['prefix' => 'assesment'], function () {
                Route::get('/', [AssesmentController::class, 'index']);
                Route::post('/store', [AssesmentController::class, 'store']);
                Route::post('/tes', [AssesmentController::class, 'tes']);
                Route::put('/update', [AssesmentController::class, 'update']);

                // grup assesment_id
                Route::group(['prefix' => '{assesment_id}'], function () {
                    Route::get('/edit', [AssesmentController::class, 'edit']);
                    Route::put('/update', [AssesmentController::class, 'update']);
                    Route::get('/delete', [AssesmentController::class, 'delete']);
                });
            });

            // grup result
            Route::group(['prefix' => 'result'], function () {
                Route::get('/', [AssesmentController::class, 'result']);
            });

        });

        // grup submission
        Route::group(['prefix' => 'submission'], function () {
            // grup cuti
            Route::group(['prefix' => 'cuti'], function () {
                Route::get('/', [SubmissionController::class, 'cuti']);
                Route::post('/store', [SubmissionController::class, 'storeCuti']);

                // grup cuti_id
                Route::group(['prefix' => '{cuti_id}'], function () {
                    Route::get('/edit', [SubmissionController::class, 'editCuti']);
                    Route::put('/update', [SubmissionController::class, 'updateCuti']);
                    Route::get('/delete', [SubmissionController::class, 'deleteCuti']);
                    Route::get('/confirm', [SubmissionController::class, 'confirmCuti']);
                    Route::put('/reject', [SubmissionController::class, 'rejectCuti']);
                    Route::put('/adjust', [SubmissionController::class, 'adjustCuti']);
                    Route::put('/update-status-description', [SubmissionController::class, 'updateStatusDescriptionCuti']);
                });
            });

            // grup izin-sakit
            Route::group(['prefix' => 'izin-sakit'], function () {
                Route::get('/', [SubmissionController::class, 'izinSakit']);
                Route::post('/store', [SubmissionController::class, 'storeIzinSakit']);

                // grup izin-sakit_id
                Route::group(['prefix' => '{id}'], function () {
                    Route::get('/edit', [SubmissionController::class, 'editIzinSakit']);
                    Route::put('/update', [SubmissionController::class, 'updateIzinSakit']);
                    Route::get('/delete', [SubmissionController::class, 'deleteIzinSakit']);
                    Route::get('/confirm', [SubmissionController::class, 'confirmIzinSakit']); 
                    Route::put('/reject', [SubmissionController::class, 'rejectIzinSakit']);
                    Route::put('/adjust', [SubmissionController::class, 'adjustIzinSakit']);
                    Route::put('/update-status-description', [SubmissionController::class, 'updateStatusDescriptionIzinSakit']);
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

        // grup meet
        Route::group(['prefix' => 'meet'], function () {
            Route::get('/', [MeetController::class, 'index']);
            Route::post('/create', [MeetController::class, 'store']);
            Route::post('/{meet}/notulensi', [MeetController::class, 'addNotulensi'])->name('meet.notulensi');
            Route::post('/{meet}/complete', [MeetController::class, 'complete'])->name('meet.complete');
            Route::post('/{meet}/accept', [MeetController::class, 'accept'])->name('meet.accept');
            Route::post('/{meet}/reject', [MeetController::class, 'reject'])->name('meet.reject');

            // grup meet_id
            Route::group(['prefix' => '{meet_id}'], function () {
                Route::put('/update', [MeetController::class, 'update']);
                Route::get('/delete', [MeetController::class, 'delete']);
            });
        });

        // grup penilaian
        Route::group(['prefix' => 'penilaian'], function () {
            Route::get('/', [PenilaianController::class, 'index']);
            Route::post('/add', [PenilaianController::class, 'add']);
            Route::post('/create', [PenilaianController::class, 'create']);

            // grup penilaian_id
            Route::group(['prefix' => '{penilaian_id}'], function () {
                Route::put('/update', [PenilaianController::class, 'update']);
                Route::put('/edit', [PenilaianController::class, 'edit']);
                Route::get('/detail', [PenilaianController::class, 'detail']);
                Route::get('/delete', [PenilaianController::class, 'delete']);
                Route::put('/nilai', [PenilaianController::class, 'nilai']);
            });
        });

        // grup leave quota
        Route::group(['prefix' => 'leave-quota'], function () {
            Route::get('/', [LeaveQuotaController::class, 'index'])->name('leave-quota.index');
            Route::post('/store', [LeaveQuotaController::class, 'store'])->name('leave-quota.store');
            Route::post('/update/{id}', [LeaveQuotaController::class, 'update'])->name('leave-quota.update');
            Route::get('/delete/{id}', [LeaveQuotaController::class, 'destroy'])->name('leave-quota.delete');
        });
        
    });

    // Attendance Summary Routes
    Route::prefix('backoffice/attendance/summary')->name('attendance.summary.')->group(function () {
        Route::get('/', [AttendanceSummaryController::class, 'index'])->name('index');
        Route::get('/create', [AttendanceSummaryController::class, 'create'])->name('create');
        Route::post('/store', [AttendanceSummaryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AttendanceSummaryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AttendanceSummaryController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [AttendanceSummaryController::class, 'delete'])->name('delete');
        Route::get('/report', [AttendanceSummaryController::class, 'report'])->name('report');
    });

});