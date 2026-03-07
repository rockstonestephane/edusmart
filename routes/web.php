<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ── Frontend Controllers ──────────────────────────────────────────────
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\FormationController;
use App\Http\Controllers\Frontend\ActualiteController;
use App\Http\Controllers\Frontend\GalerieController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\PreinscriptionController;
use App\Http\Controllers\NewsletterController;

// ── Admin Controllers ─────────────────────────────────────────────────
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\ActualiteAdminController;
use App\Http\Controllers\Admin\FormationAdminController;
use App\Http\Controllers\Admin\GalerieAdminController;
use App\Http\Controllers\Admin\TemoignageAdminController;
use App\Http\Controllers\Admin\PreinscriptionAdminController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StatistiqueController;
use App\Http\Controllers\Admin\RentreeScolaireController;
use App\Http\Controllers\Admin\ValeurController;
use App\Http\Controllers\Admin\EquipeController;
use App\Http\Controllers\Admin\AboutPageController;
use App\Http\Controllers\Admin\PageHeroController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\NewsletterAdminController;
use App\Http\Controllers\Admin\MotDirecteurController;

/*
|--------------------------------------------------------------------------
| Redirection racine → langue par défaut (fr)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/fr');
});

/*
|--------------------------------------------------------------------------
| FRONTEND — Pages publiques localisées (/fr et /en)
|--------------------------------------------------------------------------
*/
Route::prefix('{locale}')
    ->where(['locale' => 'fr|en'])
    ->middleware('setlocale')
    ->group(function () {

        Route::get('/',                  [HomeController::class,          'index'])->name('home');
        Route::get('/a-propos',          [AboutController::class,         'index'])->name('about');
        Route::get('/formations',        [FormationController::class,     'index'])->name('formations');
        Route::get('/formations/{slug}', [FormationController::class,     'show'])->name('formations.show');
        Route::get('/actualites',        [ActualiteController::class,     'index'])->name('actualites');
        Route::get('/actualites/{slug}', [ActualiteController::class,     'show'])->name('actualites.show');
        Route::get('/galerie',           [GalerieController::class,       'index'])->name('galerie');
        Route::get('/contact',           [ContactController::class,       'index'])->name('contact');
        Route::post('/contact',          [ContactController::class,       'send'])->name('contact.send');
        Route::get('/preinscription',    [PreinscriptionController::class,'index'])->name('preinscription');
        Route::post('/preinscription',   [PreinscriptionController::class,'store'])->name('preinscription.store');
        Route::post('/newsletter/subscribe', [NewsletterController::class,'subscribe'])->name('newsletter.subscribe');

    });

/*
|--------------------------------------------------------------------------
| AUTH — Login Admin
|--------------------------------------------------------------------------
*/
Route::get('/admin/login',  [App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout',[App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN — Espace protégé
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Hero Slides
        Route::resource('hero-slides', HeroSlideController::class);
        Route::post('hero-slides/{heroSlide}/toggle', [HeroSlideController::class, 'toggle'])->name('hero-slides.toggle');
        Route::post('hero-slides/reorder', [HeroSlideController::class, 'reorder'])->name('hero-slides.reorder');

        // Actualités
        Route::resource('actualites', ActualiteAdminController::class);
        Route::post('actualites/{actualite}/toggle', [ActualiteAdminController::class, 'toggle'])->name('actualites.toggle');

        // Formations
        Route::resource('formations', FormationAdminController::class);
        Route::post('formations/{formation}/toggle', [FormationAdminController::class, 'toggle'])->name('formations.toggle');
        Route::post('formations/reorder', [FormationAdminController::class, 'reorder'])->name('formations.reorder');

        // Galerie
        Route::resource('galerie', GalerieAdminController::class);
        Route::post('galerie/{galerie}/toggle', [GalerieAdminController::class, 'toggle'])->name('galerie.toggle');

        // Témoignages
        Route::resource('temoignages', TemoignageAdminController::class);
        Route::post('temoignages/{temoignage}/toggle', [TemoignageAdminController::class, 'toggle'])->name('temoignages.toggle');

        // Statistiques
        Route::resource('statistiques', StatistiqueController::class);
        Route::post('statistiques/{statistique}/toggle', [StatistiqueController::class, 'toggle'])->name('statistiques.toggle');

        // Rentrée Scolaire
        Route::resource('rentree-scolaire', RentreeScolaireController::class);
        Route::post('rentree-scolaire/{rentreeScolaire}/toggle', [RentreeScolaireController::class, 'toggle'])->name('rentree-scolaire.toggle');

        // Préinscriptions
        Route::resource('preinscriptions', PreinscriptionAdminController::class)->only(['index','show','destroy']);
        Route::post('preinscriptions/{preinscription}/statut', [PreinscriptionAdminController::class, 'statut'])->name('preinscriptions.statut');

        // Documents
        Route::resource('documents', DocumentController::class);

        // Contacts
        Route::get('contacts', [ContactAdminController::class, 'index'])->name('contacts.index');
        Route::get('contacts/{contact}', [ContactAdminController::class, 'show'])->name('contacts.show');
        Route::delete('contacts/{contact}', [ContactAdminController::class, 'destroy'])->name('contacts.destroy');
        Route::post('contacts/{contact}/toggle-lu', [ContactAdminController::class, 'toggleLu'])->name('contacts.toggle-lu');

        // À propos
        Route::get('about',  [AboutPageController::class, 'index'])->name('about.index');
        Route::put('about',  [AboutPageController::class, 'update'])->name('about.update');

        // Valeurs
        Route::resource('valeurs', ValeurController::class);
        Route::post('valeurs/{valeur}/toggle', [ValeurController::class, 'toggle'])->name('valeurs.toggle');

        // Équipe de direction
        Route::resource('equipe', EquipeController::class);
        Route::post('equipe/{equipe}/toggle', [EquipeController::class, 'toggle'])->name('equipe.toggle');

        // Mot du Directeur
        Route::get('mot-directeur',  [MotDirecteurController::class, 'edit'])->name('mot-directeur.edit');
        Route::post('mot-directeur', [MotDirecteurController::class, 'update'])->name('mot-directeur.update');

        // Paramètres école
        Route::get('parametres',  [SettingController::class, 'index'])->name('parametres.index');
        Route::post('parametres', [SettingController::class, 'update'])->name('parametres.update');

        // Images Hero des pages
        Route::get('page-heroes', [PageHeroController::class, 'index'])->name('page-heroes.index');
        Route::put('page-heroes/{page}', [PageHeroController::class, 'update'])->name('page-heroes.update');
        Route::delete('page-heroes/{page}', [PageHeroController::class, 'destroy'])->name('page-heroes.destroy');

        // Newsletter
        Route::get('newsletter', [NewsletterAdminController::class, 'index'])->name('newsletter.index');
        Route::delete('newsletter/{subscriber}', [NewsletterAdminController::class, 'destroy'])->name('newsletter.destroy');
        Route::post('newsletter/{subscriber}/toggle', [NewsletterAdminController::class, 'toggleActif'])->name('newsletter.toggle');

    });