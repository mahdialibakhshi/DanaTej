<?php

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


use Modules\Admin\Http\Controllers\SliderController;
use Modules\Admin\Http\Controllers\ProjectController;
use Modules\Admin\Http\Controllers\MenuController;
use Modules\Admin\Http\Controllers\PageController;
use Modules\Admin\Http\Controllers\BlogController;
use Modules\Admin\Http\Controllers\SettingController;
use Modules\Admin\Http\Controllers\CustomerController;
use Modules\Admin\Http\Controllers\ServiceController;
use Modules\Admin\Http\Controllers\TeamController;
use Modules\Admin\Http\Controllers\TenderController;

Route::prefix('admin-panel/management')
    ->name('admin.')
//    ->middleware('auth-panel')
    ->group(function () {
        Route::get('/', 'AdminController@index');
        //slider
        Route::resource('slider', "SliderController")->except('index');
        Route::get('/sliders/{per_page?}', [SliderController::class, 'index'])->name('sliders.index');
        Route::post('/slider/GroupRemove', [SliderController::class, 'GroupRemove'])->name('slider.GroupRemove');

        Route::resource('service', "ServiceController")->except('index');
        Route::get('/services/{per_page?}', [ServiceController::class, 'index'])->name('services.index');
        Route::post('/service/GroupRemove', [ServiceController::class, 'GroupRemove'])->name('service.GroupRemove');

        Route::resource('team', "TeamController")->except('index');
        Route::get('/teams/{per_page?}', [TeamController::class, 'index'])->name('teams.index');
        Route::post('/team/GroupRemove', [TeamController::class, 'GroupRemove'])->name('team.GroupRemove');

        Route::resource('project', "ProjectController")->except('index');
        Route::get('/projects/{per_page?}', [ProjectController::class, 'index'])->name('projects.index');
        Route::post('/project/GroupRemove', [ProjectController::class, 'GroupRemove'])->name('project.GroupRemove');

        Route::resource('customer', "CustomerController")->except('index');
        Route::get('/customers/{per_page?}', [CustomerController::class, 'index'])->name('customers.index');
        Route::post('/customer/GroupRemove', [CustomerController::class, 'GroupRemove'])->name('customer.GroupRemove');

        Route::resource('menu', "MenuController")->except('index');
        Route::get('/menus/{per_page?}', [MenuController::class, 'index'])->name('menus.index');
        Route::post('/menu/GroupRemove', [MenuController::class, 'GroupRemove'])->name('menu.GroupRemove');

        Route::resource('page', "PageController")->except('index');
        Route::get('/pages/{per_page?}', [PageController::class, 'index'])->name('pages.index');
        Route::post('/page/GroupRemove', [PageController::class, 'GroupRemove'])->name('page.GroupRemove');

        Route::resource('blog', "BlogController")->except('index');
        Route::get('/blogs/{per_page?}', [BlogController::class, 'index'])->name('blogs.index');
        Route::post('/blog/GroupRemove', [BlogController::class, 'GroupRemove'])->name('blog.GroupRemove');

        Route::resource('tender', "TenderController")->except('index');
        Route::get('/tenders/{per_page?}', [TenderController::class, 'index'])->name('tenders.index');
        Route::post('/tender/GroupRemove', [TenderController::class, 'GroupRemove'])->name('tender.GroupRemove');

        Route::resource('settings', "SettingController")->except('index');
        Route::get('/settings/{per_page?}', [SettingController::class, 'index'])->name('settings.index');


    });
Route::get('/redirect',[\Modules\Admin\Http\Controllers\AuthController::class,'index']);

Route::get('logout',function (){
    auth()->logout();
})->name('logout');

