<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ImagesController;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\TerminalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\CupConstructorController;
//use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\NeonConstructorController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Frontend\PortfolioController as FrontendPortfolioController;

use App\Http\Controllers\TagsController;
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



Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    //Route::get('/')->name('dashboard')->uses('DashboardController');

    Route::get('/', function () {
        return Inertia::render('Admin/Dashboard/Index.vue');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('neon-constructor', [NeonConstructorController::class, 'index'])->name('neon-constructor');




    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('terminal', [TerminalController::class, 'index'])->name('terminal');
    Route::post('create-order', [TerminalController::class, 'createOrder'])->name('terminal.create_order');
    Route::get('orders', [TerminalController::class, 'orders'])->name('terminal.orders');
    Route::get('settings', [TerminalController::class, 'settings'])->name('terminal.settings');
    Route::post('save-settings', [TerminalController::class, 'saveSettings'])->name('terminal.save-settings');
    Route::delete('close-order/{order}', [TerminalController::class, 'closeOrder'])->name('terminal.close-order');


    //Route::get('get-last-price/{id}', [TerminalController::class, 'getLastPrice'])->name('get_last_price');


    // Categories
    //Route::get('categories', [CategoriesController::class, 'index'])->name('categories')->middleware('remember');
    Route::get('categories', [CategoriesController::class, 'index'])->name('categories');
    Route::get('categories/create', [CategoriesController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoriesController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    Route::put('categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');


    // Notes
    Route::get('notes', [NotesController::class, 'index'])->name('notes');
    Route::get('notes/create', [NotesController::class, 'create'])->name('notes.create');
    Route::post('notes', [NotesController::class, 'store'])->name('notes.store');
    Route::get('notes/{note}/edit', [NotesController::class, 'edit'])->name('notes.edit');
    Route::put('notes/{note}', [NotesController::class, 'update'])->name('notes.update');
    Route::delete('notes/{note}', [NotesController::class, 'destroy'])->name('notes.destroy');
    Route::put('notes/{note}/restore', [NotesController::class, 'restore'])->name('notes.restore');

    // portfolios
    Route::get('portfolios', [PortfolioController::class, 'index'])->name('portfolios');
    Route::post('portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
    Route::put('portfolios/{portfolio}', [PortfolioController::class, 'update'])->name('portfolios.update');
    Route::delete('portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');

    // portfolios
    Route::get('tags', [TagsController::class, 'index'])->name('tags');
    Route::post('tags', [TagsController::class, 'store'])->name('tags.store');
    Route::put('tags/{tag}', [TagsController::class, 'update'])->name('tags.update');
    Route::delete('tags/{tag}', [TagsController::class, 'destroy'])->name('tags.destroy');


    // Users

    Route::get('users', [UsersController::class, 'index'])
        ->name('users')
        ->middleware('remember', 'auth');

    Route::get('users/create', [UsersController::class, 'create'])
        ->name('users.create')
        ->middleware('auth');

    Route::post('users', [UsersController::class, 'store'])
        ->name('users.store')
        ->middleware('auth');

    Route::get('users/{user}/edit', [UsersController::class, 'edit'])
        ->name('users.edit')
        ->middleware('auth');

    Route::put('users/{user}', [UsersController::class, 'update'])
        ->name('users.update')
        ->middleware('auth');

    Route::delete('users/{user}', [UsersController::class, 'destroy'])
        ->name('users.destroy')
        ->middleware('auth');

    Route::put('users/{user}/restore', [UsersController::class, 'restore'])
        ->name('users.restore')
        ->middleware('auth');
});


// Auth
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');


Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [LoginController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

// Dashboard

Route::get('/', [FrontendPortfolioController::class, 'index'])->name('main-page');



Route::get('cup-constructor', [CupConstructorController::class, 'index'])->name('cup-constructor');
Route::post('cup-save-image', [CupConstructorController::class, 'saveImage'])->name('cup-constructor.saveImage');
Route::post('cup-crop-image', [CupConstructorController::class, 'cropImage'])->name('cup-constructor.cropImage');




// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*');

// 500 error

Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

    echo $fail;
});
