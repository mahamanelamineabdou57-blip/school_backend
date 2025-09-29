<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    FaculteController,
    DepartementController,
    SectionController,
    EtudiantController,
    EnseignantController,
    ModuleController,
    SectionModuleController,
    InscriptionController,
    NoteController,
    TraceMessageController,
    FeeController,
    StudentFeeController,
    UniteEnseignementController,
    AcademicYearController,
    FormationController,
    RoleController,
    LogController
};
// use App\Http\Controllers\AcademicYearController;
use Illuminate\Http\Request;

// Auth routes (ex: login, register) - à sécuriser avec Sanctum
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);


// Routes protégées par Sanctum
// Route::middleware('auth:sanctum')->group(function () {
// Faculte
Route::apiResource('facultes', FaculteController::class);
// Route::put('facultes/{'),
// Departement
Route::apiResource('departements', DepartementController::class);
Route::apiResource('formations', FormationController::class);
// Section
Route::apiResource('sections', SectionController::class);
// Etudiant
Route::apiResource('etudiants', EtudiantController::class);
// Enseignant
Route::apiResource('enseignants', EnseignantController::class);
// Module
Route::apiResource('modules', ModuleController::class);
// SectionModule
Route::apiResource('section-modules', SectionModuleController::class);
// Inscription
Route::apiResource('inscriptions', InscriptionController::class);
// Note
Route::apiResource('notes', NoteController::class);
// AcademicYear
Route::apiResource('academic-years', AcademicYearController::class);
// // TraceMessage
// Route::apiResource('trace-messages', TraceMessageController::class);
// Fee
Route::apiResource('fees', FeeController::class);
// StudentFee
Route::apiResource('student-fees', StudentFeeController::class);
Route::apiResource('unite-enseignements', UniteEnseignementController::class);
// Logs
Route::apiResource('logs', LogController::class);
//Roles
Route::apiResource('roles', RoleController::class);
// Logout
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
// });
