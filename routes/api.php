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
    FeeTypeController,
    StudentFeeController,
    UniteEnseignementController,
    AcademicYearController,
    AccesController,
    AuthController,
    FormationController,
    IntefaceController,
    RoleController,
    LogController,
    PaymentHistoryController,
    PaymentReminderController,
};
use App\Http\Controllers\CarteEtudiantController;

Route::get('/inscriptions/etudiant/{etudiantId}', [InscriptionController::class, 'getByEtudiant']);
Route::get('/ues/by-formation/{formationId}', [ModuleController::class, 'getByFormation']);
Route::get('/ecues/by-ue/{ueId}', [ModuleController::class, 'getByUE']);
Route::get('/inscriptions/by-formation-semestre/{formationId}/{semestre}', [InscriptionController::class, 'getByFormationAndSemestre']);
Route::get('/notes/by-ecue/{ecueId}', [NoteController::class, 'getByECUE']);
Route::apiResource('cartes-etudiants', CarteEtudiantController::class);
Route::get('/inscriptions/by-formation-semestre', [InscriptionController::class, 'getByFormationAndSemestre']);
Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/utilisateur/{id}/acces', [\App\Http\Controllers\AccesController::class, 'getUserAccess']);
Route::apiResource('facultes', FaculteController::class);
Route::apiResource('utilisateurs', AuthController::class);
Route::apiResource('securite-access', AccesController::class);
Route::apiResource('interfaces', IntefaceController::class);
Route::post('/notes/batch', [NoteController::class, 'batchStore']);  // Ajoutez POST pour le batch
Route::apiResource('departements', DepartementController::class);
Route::apiResource('formations', FormationController::class);
Route::apiResource('sections', SectionController::class);
Route::apiResource('etudiants', EtudiantController::class);
Route::apiResource('enseignants', EnseignantController::class);
Route::apiResource('modules', ModuleController::class);
Route::apiResource('section-modules', SectionModuleController::class);
Route::apiResource('inscriptions', InscriptionController::class);
Route::apiResource('notes', NoteController::class);
Route::apiResource('academic-years', AcademicYearController::class);
Route::apiResource('unite-enseignements', UniteEnseignementController::class);
Route::apiResource('logs', LogController::class);
Route::apiResource('roles', RoleController::class);

// ── Paiements ──────────────────────────────────────────────────────
// "fees" (ancien catalogue/facture ambigu) est remplacé par "fee-types" (catalogue)
// + "student-fees" (facture réelle par étudiant). Voir migration de refonte.
Route::apiResource('fee-types', FeeTypeController::class);
Route::apiResource('student-fees', StudentFeeController::class);

// ── Historique de paiements ──────────────────────────────────────
Route::get('/payment-history/{etudiantId}',      [PaymentHistoryController::class, 'byEtudiant']);
Route::get('/payment-history/{etudiantId}/pdf',  [PaymentHistoryController::class, 'exportPdf']);
Route::post('/payment-history',                  [PaymentHistoryController::class, 'store']);

// ── Relances / Impayés ───────────────────────────────────────────
Route::get('/reminders',                         [PaymentReminderController::class, 'index']);
Route::get('/reminders/unpaid',                  [PaymentReminderController::class, 'unpaid']);
Route::post('/reminders/send/{etudiantId}',      [PaymentReminderController::class, 'send']);

Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
Route::post('/auth/verify-code', [AuthController::class, 'verifyCode']);