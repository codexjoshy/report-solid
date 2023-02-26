<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [ReportController::class, 'commissionReport'])->name('welcome');
Route::get('/report/commission', [ReportController::class, 'commissionReport'])->name('report.commission');
// Route::get('/report/commission/ref', [ReportController::class, 'commissionReportRefactor'])->name('report.commission.r');

Route::get('/report/distributor', [ReportController::class, 'distributorReport'])->name('report.distributor');
// Route::get('/report/distributor/ref', [ReportController::class, 'distributorReportRefactor'])->name('report.distributor.r');
