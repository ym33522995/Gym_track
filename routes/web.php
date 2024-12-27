<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\RecordController;

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

Route::get('/', function () {
    return view('gym_track.home');
});

Route::get('/workout/{template}/addExercise', [RecordController::class, 'addExercise']);
Route::post('/workout/{template}/saveExercise', [RecordController::class, 'saveExercise']);

Route::patch('/template/editName/{template}', [TemplateController::class, 'updateName']);
Route::get('/template/quit', [TemplateController::class, 'quit']);
Route::get('/template/create', [TemplateController::class, 'create']);
Route::post('/template/store', [TemplateController::class, 'store'])->middleware('auth');
Route::delete('template/delete/{template}', [TemplateController::class, 'delete']);
Route::get('/template', [TemplateController::class, 'index']);
Route::get('/template/{template}', [RecordController::class, 'index']);

Route::get('/exercise', [ExerciseController::class, 'show']);

Route::get('/report', [RecordController::class, 'show']);

Route::post('/record/store', [RecordController::class, 'store']);








Route::post('/workout/saveTemporaryRecord', [RecordController::class, 'saveTemporaryRecord']);

Route::get('/workout/clearTemporaryRecords', [RecordController::class, 'clearTemporaryRecords']);

Route::post('/record/saveTemporary/{template}', [RecordController::class, 'saveTemporaryRecord']);










Route::get('/dashboard', function () {
    return view('gym_track.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
