<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::view('patients', 'pages.liste_patients')->name('patients');

Route::view('rdvs', 'pages.rdvs')->name('rdvs');

Route::get('patient/{id}', function ($id) {
    return view('pages.patient', [
        'id_patient' => $id,
    ]);
})->name('patient');

Route::get('facture/{id}', function ($id) {
    return view('pages.facture', [
        'id_facture' => $id - 1,
    ]);
})->name('facture');

Route::get('facture_2/{id}', function ($id) {
    return view('pages.facture_2', [
        'id_facture' => $id - 1,
    ]);
})->name('facture_2');

Route::get('ordonnance/{id}', function ($id) {
    return view('pages.ordonnance', [
        'id_visite' => $id,
    ]);
})->name('ordonnance');
