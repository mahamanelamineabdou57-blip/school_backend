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
    AccesController,
    AuthController,
    FormationController,
    IntefaceController,
    RoleController,
    LogController,
};
use App\Http\Controllers\CarteEtudiantController;
use App\Models\Module;
use PhpParser\Node\Expr\AssignOp\Mod;
Route::get('/inscriptions/etudiant/{etudiantId}', [InscriptionController::class, 'getByEtudiant']);
Route::get('/ues/by-formation/{formationId}', [ModuleController::class, 'getByFormation']);
Route::get('/ecues/by-ue/{ueId}', [ModuleController::class, 'getByUE']);
Route::get('/inscriptions/by-formation-semestre/{formationId}/{semestre}', [InscriptionController::class, 'getByFormationAndSemestre']);
Route::get('/notes/by-ecue/{ecueId}', [NoteController::class, 'getByECUE']);
Route::apiResource('cartes-etudiants', CarteEtudiantController::class);
Route::get('/inscriptions/by-formation-semestre', [InscriptionController::class, 'getByFormationAndSemestre']);


// Auth routes (ex: login, register) - à sécuriser avec Sanctum
// Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/utilisateur/{id}/acces', [\App\Http\Controllers\AccesController::class, 'getUserAccess']);


// Routes protégées par Sanctum
// Route::middleware('auth:sanctum')->group(function () {
// Faculte
Route::apiResource('facultes', FaculteController::class);
//Utilisateurs
Route::apiResource('utilisateurs', AuthController::class);
Route::apiResource('securite-access', AccesController::class);
Route::apiResource('interfaces', IntefaceController::class);
Route::post('/notes/batch', [NoteController::class, 'batchStore']);  // Ajoutez POST pour le batch
// Departement
//utilisateur(Roles et Permissions)
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
// Route::apiResource('cartes', CarteEtudiantController::class);
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
