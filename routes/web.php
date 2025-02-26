<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\BodyWeightController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RecordExerciseController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\HowToController;

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
})->middleware('auth');

Route::get('/workout/{template}/addExercise', [RecordController::class, 'addExercise']);
Route::post('/workout/{template}/saveExercise', [RecordController::class, 'saveExercise']);
Route::post('/workout/{template}/saveTimer', [RecordController::class, 'saveTimer']);
Route::get('/workout/{template}/getTimer', [RecordController::class, 'getTimer']);


Route::patch('/template/editName/{template}', [TemplateController::class, 'updateName']);
Route::get('/template/edit/{template}', [TemplateController::class, 'edit']);
Route::get('/template/quit', [TemplateController::class, 'quit']);
Route::get('/template/create', [TemplateController::class, 'create']);
Route::post('/template/store', [TemplateController::class, 'store'])->middleware('auth');
Route::delete('template/delete/{template}', [TemplateController::class, 'delete']);
Route::get('/template', [TemplateController::class, 'index']);
Route::post('/template/{template}/deleteExercise', [TemplateController::class, 'deleteExercise']);
Route::post('/template/{template}/duplicateExercise', [TemplateController::class, 'duplicateExercise']);
Route::post('/template/{template}/saveCurrentRecord', [TemplateController::class, 'saveCurrentRecord']);
Route::get('/template/{template}', [RecordController::class, 'index']);
Route::patch('/template/update/{template}', [TemplateController::class, 'update']);


Route::post('/exercise/{exerciseId}/getNotes', [RecordExerciseController::class, 'getNotes']);
Route::post('/exercise/{exerciseId}/saveNotes', [RecordExerciseController::class, 'saveNotes']);
Route::get('/exercise/all', [ExerciseController::class, 'getAllExercises']);
Route::get('/exercise', [ExerciseController::class, 'index']);


Route::get('/report', [RecordController::class, 'show']);
Route::get('/report/get-exercises', [RecordExerciseController::class, 'getRecordExercise']);
Route::get('/report/get-records-by-exercise', [RecordExerciseController::class, 'getRecordsByExercise']);


Route::post('/record/store', [RecordController::class, 'store']);

Route::post('/home/body-weights', [BodyWeightController::class, 'store']);
Route::get('/home/body-weights/date', [BodyWeightController::class, 'getDate']);

Route::get('/calendar', [EventController::class, 'show']);
Route::get('/calendar/record-dates', [EventController::class, 'getRecordDates']);

Route::get('/total-weight', [RecordController::class, 'totalWeights']);
Route::post('/gemini-api', [BodyWeightController::class, 'getGeminiResponse']);

// Route::post('/session/exercise/{exerciseId}/delete', [SessionController::class, 'deleteNewExerciseSet']);
// Route::post('/session/exercise/{exerciseId}/duplicate', [SessionController::class, 'duplicateNewExerciseSet']);





Route::post('/workout/saveTemporaryRecord', [RecordController::class, 'saveTemporaryRecord']);

Route::get('/workout/clearTemporaryRecords', [RecordController::class, 'clearTemporaryRecords']);

Route::post('/record/saveTemporary/{template}', [RecordController::class, 'saveTemporaryRecord']);

Route::get('how-to', [HowToController::class, 'index']);









Route::get('/dashboard', function () {
    return view('gym_track.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
