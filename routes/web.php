<?php

use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\RecruiterController;
use App\Http\Controllers\Admin\ValidationOfferController;
use App\Http\Controllers\Admin\ValidationProfilController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Candidates\CandidatePageController;
use App\Http\Controllers\Candidates\CandidatureController;
use App\Http\Controllers\Candidates\OfferViewController;
use App\Http\Controllers\Candidates\ExperienceController;
use App\Http\Controllers\Candidates\FormationController;
use App\Http\Controllers\Candidates\ProfilController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OffersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Recruiters\OfferListController;
use App\Http\Controllers\Recruiters\ProfilViewController;
use App\Http\Controllers\Recruiters\RecruiterPageController;
use App\Http\Controllers\SearchController;

// Redirige l'utilisateur connecté vers l'espace correspondant à son rôle
Route::get('/dashboard', function () {
    return redirect()->route(auth()->user()->homeRoute());
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Recherche globale des barres du haut (Admin / Recruteur / Candidat)
    Route::get('/espace/recherche', [GlobalSearchController::class, 'index'])->name('dashboard.search');

    // Notifications (tous les rôles)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/dernieres', [NotificationController::class, 'latest'])->name('notifications.latest');
    Route::get('/notifications/{id}/lire', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/{id}/lire', [NotificationController::class, 'read']);
    Route::post('/notifications/tout-lire', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

require __DIR__.'/auth.php';

//Page d'accueil
Route::get('/', [HomeController::class, 'home'])->name('index');

/*Offres publiques (seulement les offres validées)*/
Route::get('/offres', [OffersController::class, 'index'])->name('offers.index');
Route::get('/offre/{id}/detail', [OffersController::class, 'show'])->name('offers.show');

//Recherche
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

//Route Page Recruteur
Route::middleware(['auth', 'role:recruteur'])->group(function () {
    Route::get('/Page-recruteur', [RecruiterPageController::class, 'index'])->name('recruiters.recruiter');

    Route::get('/recruteurs/offres', [OfferListController::class, 'index'])->name('recruiters.offers.index');
    Route::get('/recruteurs/offre/{offre}/details', [OfferListController::class, 'show'])->name('recruiters.offers.show');
    Route::get('/recruteurs/offre/creation-offres', [OfferListController::class, 'create'])->name('recruiters.offers.create');
    Route::get('/recruteurs/offre/{offre}/editer-offres', [OfferListController::class, 'edit'])->name('recruiters.offers.edit');
    Route::post('/recruteurs/offre/store', [OfferListController::class, 'store'])->name('recruiters.offers.store');
    Route::post('/recruteurs/offre/{offre}/update', [OfferListController::class, 'update'])->name('recruiters.offers.update');
    Route::post('/recruteurs/offre/{offre}/destroy', [OfferListController::class, 'destroy'])->name('recruiters.offers.destroy');

    Route::get('/recruteur/profils', [ProfilViewController::class, 'index'])->name('recruiters.profils.index');
    Route::get('/recruteur/profil/{user}/details', [ProfilViewController::class, 'show'])->name('recruiters.profils.show');
});

//Route Page Candidat
Route::middleware(['auth', 'role:candidat'])->group(function () {
    Route::get('/candidat/offres', [OfferViewController::class, 'index'])->name('candidates.offers.index');
    Route::get('/candidat/offre/{offre}/details', [OfferViewController::class, 'show'])->name('candidates.offers.show');
    Route::post('/candidat/offre/{offre}/postuler', [CandidatureController::class, 'store'])->name('candidates.offers.apply');
    Route::get('/candidat/candidatures', [CandidatureController::class, 'index'])->name('candidates.candidatures.index');

    Route::get('/Page-candidat', [CandidatePageController::class, 'index'])->name('candidates.candidate');

    // Route Profil
    Route::get('/candidats/profils', [ProfilController::class, 'index'])->name('candidates.profils.profil');
    Route::get('/candidats/profil/{user}/details', [ProfilController::class, 'show'])->name('candidates.profils.show');
    Route::get('/candidats/profil/creation-profils', [ProfilController::class, 'create'])->name('candidates.profils.create');
    Route::get('/candidats/profil/{profil}/editer-profils', [ProfilController::class, 'edit'])->name('candidates.profils.edit');
    Route::post('/candidats/profil/store', [ProfilController::class, 'store'])->name('candidates.profils.store');
    Route::post('/candidats/profil/{profil}/update', [ProfilController::class, 'update'])->name('candidates.profils.update');
    Route::post('/candidats/profil/{profil}/destroy', [ProfilController::class, 'destroy'])->name('candidates.profils.destroy');

    //Route formation
    Route::get('/candidats/formations', [FormationController::class, 'index'])->name('candidates.formations.index');
    Route::get('/candidats/formation/{formation}/details', [FormationController::class, 'show'])->name('candidates.formations.show');
    Route::get('/candidats/formation/creation-formations', [FormationController::class, 'create'])->name('candidates.formations.create');
    Route::get('/candidats/formation/{formation}/editer-formations', [FormationController::class, 'edit'])->name('candidates.formations.edit');
    Route::post('/candidats/formation/store', [FormationController::class, 'store'])->name('candidates.formations.store');
    Route::post('/candidats/formation/{formation}/update', [FormationController::class, 'update'])->name('candidates.formations.update');
    Route::post('/candidats/formation/{formation}/destroy', [FormationController::class, 'destroy'])->name('candidates.formations.destroy');

    //Route Experience
    Route::get('/candidats/experiences', [ExperienceController::class, 'index'])->name('candidates.experiences.index');
    Route::get('/candidats/experience/{experience}/details', [ExperienceController::class, 'show'])->name('candidates.experiences.show');
    Route::get('/candidats/experience/creation-experiences', [ExperienceController::class, 'create'])->name('candidates.experiences.create');
    Route::get('/candidats/experience/{experience}/editer-experiences', [ExperienceController::class, 'edit'])->name('candidates.experiences.edit');
    Route::post('/candidats/experience/store', [ExperienceController::class, 'store'])->name('candidates.experiences.store');
    Route::post('/candidats/experience/{experience}/update', [ExperienceController::class, 'update'])->name('candidates.experiences.update');
    Route::post('/candidats/experience/{experience}/destroy', [ExperienceController::class, 'destroy'])->name('candidates.experiences.destroy');
});

//Page Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/recruteurs', [RecruiterController::class, 'index'])->name('admin.recruiters');
    Route::get('/candidats', [CandidateController::class, 'index'])->name('admin.candidates');
    Route::delete('/admin/users/{user}', [RecruiterController::class, 'destroy'])->name('admin.recruiters.destroy');

    //Validation offre
    Route::get('/admin/offres', [ValidationOfferController::class, 'index'])->name('admin.offers.index');
    Route::get('/admin/offre/{offre}/details', [ValidationOfferController::class, 'show'])->name('admin.offers.show');

    Route::post('/admin/offre/{offre}/valider', [ValidationOfferController::class, 'valider'])->name('admin.offre.valider');
    Route::post('/admin/offre/{offre}/refuser', [ValidationOfferController::class, 'refuser'])->name('admin.offre.refuser');

    //Validation Profil
    Route::get('/admin/profils', [ValidationProfilController::class, 'index'])->name('admin.profils.index');
    Route::get('/admin/profil/{user}/details', [ValidationProfilController::class, 'show'])->name('admin.profils.show');

    Route::post('/admin/profils/{user}/valider', [ValidationProfilController::class, 'valider'])->name('admin.profils.valider');
    Route::post('/admin/profils/{user}/refuser', [ValidationProfilController::class, 'refuser'])->name('admin.profils.refuser');

    // Gestion manuelle des offres (anciennes pages offers/*)
    Route::get('/offre/creation', [OffersController::class, 'create'])->name('offers.create');
    Route::get('offre/{id}/edition', [OffersController::class, 'edit'])->name('offers.edit');
    Route::post('offre/store', [OffersController::class, 'store'])->name('offers.store');
    Route::put('offre/{id}/update', [OffersController::class, 'update'])->name('offers.update');
    Route::post('offre/{id}/destroy', [OffersController::class, 'destroy'])->name('offers.destroy');
});
