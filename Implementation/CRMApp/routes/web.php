<?php

use App\Http\Controllers\ContactPersonController;
use App\Http\Controllers\CustomerController;

use App\Http\Controllers\CustomerSolutionController;
use App\Http\Controllers\GitlabProjectController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\TicketController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Register routes for Customer Solutions
    Route::resource('customers.solutions', CustomerSolutionController::class);

//    Register routes for customer CRUD and (de-)activation
    Route::put('customers/{registration_number}/active/{active}', [CustomerController::class, 'active'])->name(
        'customers.active'
    );
    Route::resource('customers', CustomerController::class)->missing(function (Request $request) {
        return Redirect::route('customers.index');
    });

    Route::resource('customers.contact_persons', ContactPersonController::class);
    Route::resource('customers.tickets', TicketController::class);
    Route::resource('customers.gitlab_projects', GitlabProjectController::class);

//      Register routes for solution CRUD
    Route::resource('solutions', SolutionController::class)->missing(function (Request $request) {
        return Redirect::route('solutions.index');
    });
//      Register routes for CRUD ContactPerson

});
