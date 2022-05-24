<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;

Route::get("/", [LoginController::class, "goLogin"]);
Route::post("/login", [LoginController::class, "login"]);
Route::get("/logout", [LoginController::class, "logout"]);
Route::get("/goTop", [TopController::class, "goTop"]);

Route::get("/subject/showSubjectList", [SubjectController::class, "showSubjectList"]);
Route::get("/subject/goSubjectAdd", [SubjectController::class, "goSubjectAdd"]);
Route::post("/subject/subjectAdd", [SubjectController::class, "subjectAdd"]);
Route::get("/subject/prepareSubjectEdit/{mark}", [SubjectController::class, "prepareSubjectEdit"]);
Route::post("/subject/subjectEdit", [SubjectController::class, "subjectEdit"]);
Route::get("/subject/confirmSubjectDelete/{mark}", [SubjectController::class, "confirmSubjectDelete"]);
Route::post("/subject/subjectDelete", [SubjectController::class, "subjectDelete"]);

Route::get('/task/showTaskList', [TaskController::class, 'showTaskList']);
Route::get('/task/goTaskAdd',  [TaskController::class, 'goTaskAdd']);
Route::post('/task/taskAdd',  [TaskController::class, 'taskAdd']);
Route::get('/task/prepareTaskEdit/{id}', [TaskController::class, 'prepareTaskEdit']);
Route::post('/task/taskEdit', [TaskController::class, 'taskEdit']);
Route::get('/task/confirmTaskDelete/{id}', [TaskController::class, 'confirmTaskDelete']);
Route::post('/task/taskDelete', [TaskController::class, 'taskDelete']);