<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;
use Livewire\Commands\StubsCommand;

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

Route::get('/', [StudentController::class, 'index']);
Route::get('/search', [studentController::class, 'search']);

Route::prefix('teacher')->middleware([
    'auth',
    'is_teacher'
])->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'index'])->name('dashboard');
    Route::post('/create', [TeacherController::class, 'create']);
    Route::get('/create', function () {
        return view('teacher.createCourse');
    });
});

Route::prefix('student')->middleware([
    'auth'
])->group(function () {
    Route::post('/comment/{id}', [StudentController::class, 'comment']);
    Route::get('/reserve/{id}', [StudentController::class, 'reserve']);
    Route::delete('/cancel/{id}', [StudentController::class, 'cancel']);
    Route::get('/myCourse', [StudentController::class, 'check']);
    Route::get('/comment/{course}', [StudentController::class, 'commentIndex']);
});
