<?php

declare(strict_types=1);

use App\Orchid\Screens\Demande\Chart\DemandeChartScreen;
use App\Orchid\Screens\Demande\DemandeEditScreen;
use App\Orchid\Screens\Demande\DemandeListScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Service\Chart\BaseChartScreen;
use App\Orchid\Screens\Service\Chart\ServiceChartScreen;
use App\Orchid\Screens\ServiceEditeScreen;
use App\Orchid\Screens\ServiceScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
// Route::screen('/main', PlatformScreen::class)
//     ->name('platform.main');
Route::screen('platform.presentation', PlatformScreen::class)
    ->name('platform.presentation');
// Route::screen('/main', BaseChartScreen::class)
//     ->name('platform.main');

Route::screen('/main', BaseChartScreen::class)
    ->name('platform.main')->middleware('userchart');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{roles}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Example screen');
    });

Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('example-charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('example-editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('example-cards', ExampleCardsScreen::class)->name('platform.example.cards');
Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');

//Route::screen('idea', 'Idea::class','platform.screens.idea');

Route::screen('services/list', ServiceScreen::class)->name('platform.services.list');
Route::screen('service/create', ServiceEditeScreen::class)->name('platform.service.create');
Route::screen('service/{id}/edit', ServiceEditeScreen::class)->name('platform.service.edit');


Route::screen('demandes/list', DemandeListScreen::class)
        ->name('platform.demandes.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__('demandes'), route('platform.demandes.list'));
        });
Route::screen('demande/create', DemandeEditScreen::class)
        ->name('platform.demande.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.demandes.list')
                ->push(__('Create'), route('platform.demande.create'));
        });
Route::screen('demande/{id}/edit', DemandeEditScreen::class)
        ->name('platform.demande.edit')
        ->breadcrumbs(function (Trail $trail, $id) {
            return $trail
                ->parent('platform.demandes.list')
                ->push(__('demande'), route('platform.demande.edit', $id));
        });

Route::screen('demandes/charts', DemandeChartScreen::class)->name('platform.demandes.charts');
Route::screen('services/charts', ServiceChartScreen::class)->name('platform.services.charts');

