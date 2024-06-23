<?php

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

Route::get('/', function () {
    return redirect('dashboard');
});

Route::group([
    'prefix'     => config('boilerplate.app.prefix', ''),
    'middleware' => ['web', 'boilerplate.locale'],
    'as'         => 'mantra.',
], function () {

    Route::group(['middleware' => ['boilerplate.auth', 'ability:admin,backend_access', 'boilerplate.emailverified']], function () {

        Route::prefix('botagents')->as('botagents.')->group(function () {
            Route::get('register', [App\Http\Controllers\Mantra\BotAgentsController::class, 'registerAgent'])->name('register');
            Route::post('register', [App\Http\Controllers\Mantra\BotAgentsController::class, 'createNewAgent'])->name('register.post');

            Route::get('active', [App\Http\Controllers\Mantra\BotAgentsController::class, 'activeAgents'])->name('active');
            Route::get('inactive', [App\Http\Controllers\Mantra\BotAgentsController::class, 'inactiveAgents'])->name('inactive');
            Route::delete('inactive/{uuid}', [App\Http\Controllers\Mantra\BotAgentsController::class, 'deleteAgent'])->name('destroy');

            Route::get('activate/{uuid}', [App\Http\Controllers\Mantra\BotAgentsController::class, 'activateAgent'])->name('activate');
            Route::get('qrcode/{uuid}', [App\Http\Controllers\Mantra\BotAgentsController::class, 'qrCodeSession'])->name('qrcode');
            Route::delete('inactivate/{uuid}', [App\Http\Controllers\Mantra\BotAgentsController::class, 'inactivateAgent'])->name('inactivate');

            Route::get('logs', [App\Http\Controllers\Mantra\BotAgentsController::class, 'logs'])->name('logs');
            Route::get('logs/{uuid}', [App\Http\Controllers\Mantra\BotAgentsController::class, 'logDetail'])->name('logs.detail');

            Route::get('detail/{uuid}.json', [App\Http\Controllers\Mantra\BotAgentsController::class, 'detailBotJson'])->name('detail.json');
        });

        Route::prefix('phonebook')->as('phonebook.')->group(function () {
            Route::get('upload', [App\Http\Controllers\Mantra\PhoneBookController::class, 'uploadBook'])->name('upload');
            Route::post('upload', [App\Http\Controllers\Mantra\PhoneBookController::class, 'uploadPhoneContacts'])->name('upload.post');
            Route::get('list', [App\Http\Controllers\Mantra\PhoneBookController::class, 'listBook'])->name('list');
            Route::get('{uuid}/list', [App\Http\Controllers\Mantra\PhoneBookController::class, 'listPhoneContacts'])->name('phonecontact.list');

            Route::delete('/{uuid}', [App\Http\Controllers\Mantra\PhoneBookController::class, 'deletePhoneBook'])->name('destroy');
            Route::delete('/contact/{uuid}', [App\Http\Controllers\Mantra\PhoneBookController::class, 'deletePhoneContact'])->name('phonecontact.destroy');
        });

        Route::prefix('greetings')->as('greetings.')->group(function () {
            Route::get('create', [App\Http\Controllers\Mantra\GreetingsTemplateController::class, 'create'])->name('create');
            Route::get('list', [App\Http\Controllers\Mantra\GreetingsTemplateController::class, 'list'])->name('list');
        });

        Route::prefix('reports')->as('reports.')->group(function () {
            Route::get('activenumbers', [App\Http\Controllers\Mantra\ReportsController::class, 'activeNumbers'])->name('activenumbers');
        });

    });

});