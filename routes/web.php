<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\ClientPageController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;

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

// Main Page Route
Route::get('/', [ClientPageController::class, 'index'])->name('home');
Route::get('/suggestion-paper', [ClientPageController::class, 'suggestionPaper'])->name('suggest-paper');
Route::post('/topic-list', [ClientPageController::class, 'topicList'])->name('client.topics');
Route::post('/ques-range', [ClientPageController::class, 'quesRange'])->name('client.questions.range');
Route::post('/exam-info', [ClientPageController::class, 'examInfo'])->name('exam.info');
Route::get('/exam/{exam_id}', [ClientPageController::class, 'exam'])->name('client.exam');
Route::post('/exam', [ClientPageController::class, 'examSubmit'])->name('exam.submit');
Route::get('/result/{exam_id}', [ClientPageController::class, 'result'])->name('client.result');


Route::middleware(['auth'])->group(function () {
  Route::get('/question', [QuestionController::class, 'index'])->name('question');
  Route::get('/question-add', [QuestionController::class, 'questionCreate'])->name('create-question');
  Route::post('/question-post', [QuestionController::class, 'questionStore'])->name('store-question');

  Route::get('/edit-question/{id}', [QuestionController::class, 'edit'])->name('edit-question');
  Route::post('/edit-question/{id}', [QuestionController::class, 'update'])->name('update-question');

  Route::get('/delete-question/{id}', [QuestionController::class, 'delete'])->name('delete-question');


  Route::get('/exam-list', [ExamController::class, 'index'])->name('examination');
  Route::get('/exam-view/{exam_id}', [ExamController::class, 'show'])->name('exam-view');

  // fix-group-question
  Route::get('/fix-group-questions', [QuestionController::class, 'fixGroupQuestion'])->name('fix-group-question');
  Route::get('/group-questions/{group_id}/{country_id}', [QuestionController::class, 'addQuestionsOnGroup'])->name('group-question');
});



// Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

// // locale
// Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// // pages
// Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginConfirm'])->name('loginConfirm');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
