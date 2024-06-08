<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/categories', CategoryController::class);
    /** php artisan r:l --path=categories
     * Http Action     urlPath                             name route       controller method
     * GET|HEAD        categories ....................... categories.index › CategoryController@index
     * POST            categories ....................... categories.store › CategoryController@store
     * GET|HEAD        categories/create ................ categories.create › CategoryController@create
     * GET|HEAD        categories/{category} ............ categories.show › CategoryController@show
     * PUT|PATCH       categories/{category} ............ categories.update › CategoryController@update
     * DELETE          categories/{category} ............ categories.destroy › CategoryController@destroy
     * GET|HEAD        categories/{category}/edit ....... categories.edit › CategoryController@edit
     */
    Route::resource('/budgets', BudgetController::class);
    /**
     * Http Action     urlPath                    name route       controller method
     * GET|HEAD        budgets .................. budgets.index › BudgetController@index
     * POST            budgets .................. budgets.store › BudgetController@store
     * GET|HEAD        budgets/create ........... budgets.create › BudgetController@create
     * GET|HEAD        budgets/{budget} ......... budgets.show › BudgetController@show
     * PUT|PATCH       budgets/{budget} ......... budgets.update › BudgetController@update
     * DELETE          budgets/{budget} ......... budgets.destroy › BudgetController@destroy
     * GET|HEAD        budgets/{budget}/edit .... budgets.edit › BudgetController@edit
     */
    Route::resource('/transactions', TransactionController::class);
    /**
     * Http Action     urlPath                               name route          controller method
     * GET|HEAD        transactions ....................... transactions.index › TransactionController@index
     * POST            transactions ....................... transactions.store › TransactionController@store
     * GET|HEAD        transactions/create ................ transactions.create › TransactionController@create
     * GET|HEAD        transactions/{transaction} ......... transactions.show › TransactionController@show
     * PUT|PATCH       transactions/{transaction} ......... transactions.update › TransactionController@update
     * DELETE          transactions/{transaction} ......... transactions.destroy › TransactionController@destroy
     * GET|HEAD        transactions/{transaction}/edit .... transactions.edit › TransactionController@edit
     */

});

require __DIR__.'/auth.php';

