<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashBoardController;
use App\Http\Controllers\Admin\QuestionManagementController;

/*
|--------------------------------------------------------------------------
| Administrator Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('administrator')->group(function () {

    Route::prefix('auth')->group(function () {
        
        //Admin before login routes
        Route::name('admin.auth.')->group(function () {
            Route::get('/', [AdminAuthController::class, 'index'])->name('login');
            Route::post('/', [AdminAuthController::class, 'loginAction'])->name('login.action');
        });

        //Admin after login routes
        Route::prefix('account')->group(function () {
            
            Route::name('admin.account.dashboard.')->group(function () {
                Route::get('/', [AdminDashBoardController::class, 'index'])->name('index');
                Route::get('/dashboard', [AdminDashBoardController::class, 'index'])->name('index');
            });

            //Logout
            Route::get('/logout', [AdminDashBoardController::class, 'logout'])->name('admin.account.logout');
            
            //Question Management
            Route::prefix('question-management')->group(function () {
                Route::name('admin.account.question.')->group(function () {
                    Route::get('/', [QuestionManagementController::class, 'index'])->name('index');
                    Route::get('/add', [QuestionManagementController::class, 'addQuestion'])->name('add');
                    Route::post('/add', [QuestionManagementController::class, 'saveQuestion'])->name('create');
                    Route::get('/upload-csv', [QuestionManagementController::class, 'uploadQuestions'])->name('upload_csv');
                    Route::post('/upload-csv', [QuestionManagementController::class, 'uploadQuestionsAction'])->name('upload_csv_action');
                    Route::post('/export-questions', [QuestionManagementController::class, 'exportQuestions'])->name('export_questions');
                    Route::get('/edit/{id}', [QuestionManagementController::class, 'editQuestion'])->name('edit');
                    Route::post('/edit/{id}', [QuestionManagementController::class, 'updateQuestion'])->name('update');
                    Route::get('/delete/{id}', [QuestionManagementController::class, 'deleteQuestion'])->name('delete');
                });
            });

            
        });
    });
});


