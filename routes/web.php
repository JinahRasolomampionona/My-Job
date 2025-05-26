<?php

use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\RecruiterController;
use App\Http\Controllers\Admin\ValidationOfferController;
use App\Http\Controllers\Admin\ValidationProfilController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Candidates\CandidatePageController;
use App\Http\Controllers\Candidates\OfferViewController;
use App\Http\Controllers\Candidates\ExperienceController;
use App\Http\Controllers\Candidates\FormationController;
use App\Http\Controllers\Candidates\ProfilController;
use App\Http\Controllers\GmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OffersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Recruiters\OfferListController;
use App\Http\Controllers\Recruiters\ProfilViewController;
use App\Http\Controllers\Recruiters\RecruiterPageController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    return view('index'); // Optionnel, si aucun rôle ne correspond
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Page d'accueil
Route::get('/', [HomeController::class, 'home'])->name('index');

/*Offres*/
Route::get('/offres', [OffersController::class, 'index'])->name('offers.index');
Route::get('/offre/{id}/detail', [OffersController::class, 'show'])->name('offers.show');
Route::get('/offre/creation', [OffersController::class, 'create'])->name('offers.create');
Route::get('offre/{id}/edition', [OffersController::class, 'edit'])->name('offers.edit');
Route::post('offre/store', [OffersController::class, 'store'])->name('offers.store');
Route::put('offre/{id}/update', [OffersController::class, 'update'])->name('offers.update');
Route::post('offre/{id}/destroy', [OffersController::class, 'destroy'])->name('offers.destroy');

//Route Page Recruteur
Route::get('/Page-recruteur', [RecruiterPageController::class, 'index'])->name('recruiters.recruiter');

Route::get('/recruteurs/offres', [OfferListController::class, 'index'])->name('recruiters.offers.index');
Route::get('/recruteurs/offre/{offre}/details', [OfferListController::class, 'show'])->name('recruiters.offers.show');
Route::get('/recruteurs/offre/creation-offres', [OfferListController::class, 'create'])->name('recruiters.offers.create');
Route::get('/recruteurs/offre/{offre}/editer-offres', [OfferListController::class, 'edit'])->name('recruiters.offers.edit');
Route::post('/recruteurs/offre/store', [OfferListController::class, 'store'])->name('recruiters.offers.store');
Route::post('/recruteurs/offre/{offre}/update', [OfferListController::class, 'update'])->name('recruiters.offers.update');
Route::post('/recruteurs/offre/{offre}/destroy', [OfferListController::class, 'destroy'])->name('recruiters.offers.destroy');

Route::get('/recruteur/profils', [ProfilViewController::class, 'index'])->name('recruiters.profiles.index');
Route::get('/recruteur/profil/{user}/details', [ProfilViewController::class, 'show'])->name('recruiters.profiles.show');

//Route Page Candidat
Route::get('/candidat/offres', [OfferViewController::class, 'index'])->name('candidates.offers.index');
Route::get('/candidat/offre/{offre}/details', [OfferViewController::class, 'show'])->name('candidates.offers.show');

Route::get('/Page-candidat', [CandidatePageController::class, 'index'])->name('candidates.candidate');

// Route Profil
Route::get('/candidats/profils', [ProfilController::class, 'index'])->name('candidates.profiles.profil');
Route::get('/candidats/profil/{user}/details', [ProfilController::class, 'show'])->name('candidates.profiles.show');
Route::get('/candidats/profil/creation-profils', [ProfilController::class, 'create'])->name('candidates.profiles.create');
Route::get('/candidats/profil/{profil}/editer-profils', [ProfilController::class, 'edit'])->name('candidates.profiles.edit');
Route::post('/candidats/profil/store', [ProfilController::class, 'store'])->name('candidates.profiles.store');
Route::post('/candidats/profil/{profil}/update', [ProfilController::class, 'update'])->name('candidates.profiles.update');
Route::post('/candidats/profil/{profil}/destroy', [ProfilController::class, 'destroy'])->name('candidates.profiles.destroy');

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


//Page Admin
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
Route::get('/admin/profils', [ValidationProfilController::class, 'index'])->name('admin.profiles.index');
Route::get('/admin/profil/{user}/details', [ValidationProfilController::class, 'show'])->name('admin.profiles.show');

//Recherche
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

//Email
Route::get('/sendEmail', [GmailController::class, 'send'])->name('gmail.send');



