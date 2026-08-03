<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AsesorController;
use App\Http\Controllers\AsesiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SuperadminController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/pendaftaran', [LandingController::class, 'pendaftaran'])->name('pendaftaran');
Route::post('/enroll', [EnrollmentController::class, 'enroll'])->name('enroll');
Route::post('/enroll/send-otp', [EnrollmentController::class, 'sendOtp'])->name('enroll.send-otp');
Route::post('/enroll/payment', [EnrollmentController::class, 'processPayment'])->name('enroll.payment');
Route::get('/api/verify-certificate', [LandingController::class, 'verifyCertificate'])->name('api.verify-certificate');
Route::post('/api/guest-book', [LandingController::class, 'storeGuestBook'])->name('api.guest-book.store');
Route::get('/api/guest-book', [LandingController::class, 'getGuestBooks'])->name('api.guest-book.list');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/admin/login', [AuthController::class, 'showLogin']); // backward compat
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// Google SSO OAuth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Local Mock Google SSO Routes
Route::get('/admin/login/mock-google', [AuthController::class, 'showMockGoogle'])->name('auth.mock-google');
Route::post('/admin/login/mock-google-callback', [AuthController::class, 'handleMockGoogleCallback'])->name('auth.mock-google-callback');

// ─── Protected Routes ───────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // ── Superadmin Dashboard ──────────────────────────────────────────────
    Route::get('/dashboard/superadmin', [SuperadminController::class, 'index'])->name('superadmin.dashboard');
    Route::post('/dashboard/superadmin/settings', [SuperadminController::class, 'updateSettings'])->name('superadmin.settings.update');
    Route::post('/dashboard/superadmin/profile', [SuperadminController::class, 'updateProfile'])->name('superadmin.profile.update');
    Route::post('/dashboard/superadmin/users', [SuperadminController::class, 'storeUser'])->name('superadmin.user.store');
    Route::delete('/dashboard/superadmin/users/{id}', [SuperadminController::class, 'destroyUser'])->name('superadmin.user.destroy');
    Route::post('/dashboard/superadmin/articles', [SuperadminController::class, 'storeArticle'])->name('superadmin.articles.store');
    Route::delete('/dashboard/superadmin/articles/{id}', [SuperadminController::class, 'destroyArticle'])->name('superadmin.articles.destroy');

    // ── Admin Dashboard ───────────────────────────────────────────────────
    Route::get('/dashboard/admin', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/admin/report', [DashboardAdminController::class, 'generateReport'])->name('admin.report');
    Route::post('/dashboard/admin/asesor', [DashboardAdminController::class, 'storeAsesor'])->name('admin.asesor.store');
    Route::post('/dashboard/admin/asesi', [DashboardAdminController::class, 'storeAsesi'])->name('admin.asesi.store');
    Route::delete('/dashboard/admin/user/{id}', [DashboardAdminController::class, 'destroyUser'])->name('admin.user.destroy');
    Route::post('/dashboard/admin/assign-scheme', [DashboardAdminController::class, 'assignScheme'])->name('admin.scheme.assign');
    Route::delete('/dashboard/admin/assignment/{id}', [DashboardAdminController::class, 'revokeAssignment'])->name('admin.scheme.revoke');
    Route::post('/dashboard/admin/profile', [DashboardAdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/dashboard/admin/trainees/{id}/approve', [DashboardAdminController::class, 'approveTrainee'])->name('admin.trainees.approve');
    Route::post('/dashboard/admin/trainees/{id}/verify-payment', [DashboardAdminController::class, 'verifyPayment'])->name('admin.trainees.verify-payment');
    Route::post('/dashboard/admin/articles', [DashboardAdminController::class, 'storeArticle'])->name('admin.articles.store');
    Route::delete('/dashboard/admin/articles/{id}', [DashboardAdminController::class, 'destroyArticle'])->name('admin.articles.destroy');

    // ── Asesor Dashboard & Scheme Builder ────────────────────────────────
    Route::get('/dashboard/asesor', [AsesorController::class, 'index'])->name('asesor.dashboard');
    Route::post('/dashboard/asesor/schemes', [AsesorController::class, 'storeScheme'])->name('asesor.scheme.store');
    Route::get('/dashboard/asesor/schemes/{id}/edit', [AsesorController::class, 'editScheme'])->name('asesor.scheme.edit');
    Route::put('/dashboard/asesor/schemes/{id}', [AsesorController::class, 'updateScheme'])->name('asesor.scheme.update');
    Route::post('/dashboard/asesor/schemes/{id}/toggle-publish', [AsesorController::class, 'togglePublish'])->name('asesor.scheme.toggle-publish');
    Route::post('/dashboard/asesor/profile', [AsesorController::class, 'updateProfile'])->name('asesor.profile.update');
    Route::delete('/dashboard/asesor/schemes/{id}', [AsesorController::class, 'deleteScheme'])->name('asesor.scheme.delete');
    Route::post('/dashboard/asesor/schemes/{schemeId}/questions', [AsesorController::class, 'storeQuestion'])->name('asesor.question.store');
    Route::delete('/dashboard/asesor/schemes/{schemeId}/questions/{questionId}', [AsesorController::class, 'deleteQuestion'])->name('asesor.question.delete');
    Route::post('/dashboard/asesor/schedules', [AsesorController::class, 'storeSchedule'])->name('asesor.schedule.store');
    Route::delete('/dashboard/asesor/schedules/{id}', [AsesorController::class, 'destroySchedule'])->name('asesor.schedule.destroy');
    Route::post('/dashboard/asesor/syllabus/{id}', [AsesorController::class, 'updateSyllabus'])->name('asesor.syllabus.update');

    // ── Asesi Dashboard & Exam (LMS) ──────────────────────────────────────
    Route::get('/dashboard/asesi', [AsesiController::class, 'index'])->name('asesi.dashboard');
    Route::get('/asesi/exam/{schemeId}', [AsesiController::class, 'startScheme'])->name('asesi.exam.start');
    Route::post('/asesi/exam/{attemptId}/answer', [AsesiController::class, 'saveAnswer'])->name('asesi.exam.answer');
    Route::post('/asesi/exam/{attemptId}/finish', [AsesiController::class, 'finishScheme'])->name('asesi.exam.finish');
    Route::get('/asesi/result/{attemptId}', [AsesiController::class, 'result'])->name('asesi.result');
    Route::post('/dashboard/asesi/profile', [AsesiController::class, 'updateProfile'])->name('asesi.profile.update');
    Route::get('/dashboard/asesi/certificate/{id}', [AsesiController::class, 'downloadCertificate'])->name('asesi.certificate.download');

    // ── Legacy admin routes (backward compat for existing views) ──────────
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.legacy.dashboard');
    Route::post('/admin/seed', [AdminController::class, 'seed'])->name('admin.seed');
    Route::post('/admin/reset', [AdminController::class, 'reset'])->name('admin.reset');
    Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/admin/users', [AdminController::class, 'storeAdmin'])->name('admin.users.store');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyAdmin'])->name('admin.users.destroy');
});

// Fallback/web-safe mapping of the verification API
Route::get('/api/verify-certificate', [ApiController::class, 'verifyCertificate'])->name('api.verify.web');
