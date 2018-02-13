<?php

/*
|--------------------------------------------------------------------------
| #WEB
|--------------------------------------------------------------------------
*/



use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\PasswordController;
use App\Controllers\Dashboard\DashController;
use App\Controllers\Dashboard\HeroSlidesController;
use App\Controllers\Dashboard\InstructorsController;
use App\Controllers\Dashboard\SchedulesController;
use App\Controllers\Dashboard\TestimoniesController;
use App\Controllers\Dashboard\UsersController;
use App\Controllers\ErrorsController;
use App\Controllers\HomeController;



// #HOME
// =========================================================================

$app->get('/', HomeController::class . ':index')->setName("home");
$app->post('/', HomeController::class . ':post');
$app->get('/404', ErrorsController::class . ':error404')->setName("error404");
$app->get('/trainer/{id}', HomeController::class . ':trainer')->setName('trainerBio');




// #AUTH / DASHBOARD
// =========================================================================

$app->group('/admin', function(){
    $this->get('', DashController::class . ':index')->setName('dash');
    $this->get('/login', AuthController::class . ':showLogin')->setName('login');
    $this->post('/login', AuthController::class . ':postLogin');
    $this->get('/logout', AuthController::class . ':getLogout')->setName('logout');
});




// #PASSWORD RESET
// =========================================================================

$app->get('/forgot', PasswordController::class . ':getForgot')->setName('forgot');
$app->post('/forgot', PasswordController::class . ':postForgot');
$app->get('/reset/{token}', PasswordController::class . ':getReset')->setName('reset');
$app->post('/reset/{token}', PasswordController::class . ':postReset');




// #HERO SLIDES
// =========================================================================

$app->group('/admin/hero-slides', function(){
    $this->get('', HeroSlidesController::class . ':index')->setName('hero.index');
    $this->get('/edit/{slug}', HeroSlidesController::class . ':edit')->setName('hero.edit');
    $this->post('/{slug}/update', HeroSlidesController::class . ':update')->setName('hero.update');
    $this->get('/{slug}', HeroSlidesController::class . ':show')->setName('hero.view');
});




// #INSTRUCTORS
// =========================================================================

$app->group('/admin/instructors', function(){
    $this->get('', InstructorsController::class . ':index')->setName('instructors.index');
    $this->get('/create', InstructorsController::class . ':create')->setName('instructors.create');
    $this->post('/create', InstructorsController::class . ':store');
    $this->get('/edit/{id}', InstructorsController::class . ':edit')->setName('instructors.edit');
    $this->get('/delete/{id}', InstructorsController::class . ':delete')->setName('instructors.delete');
    $this->post('/{id}/update', InstructorsController::class . ':update')->setName('instructors.update');
    $this->get('/{id}', InstructorsController::class . ':show')->setName('instructors.view');
});




// #SCHEDULES
// =========================================================================

$app->group('/admin/schedules', function(){
    $this->get('', SchedulesController::class . ':index')->setName('schedules.index');
    $this->post('/{slug}/update', SchedulesController::class . ':update')->setName('schedules.update');
});




// #TESTIMONIES
// =========================================================================

$app->group('/admin/testimonies', function(){
    $this->get('', TestimoniesController::class . ':index')->setName('testimonies.index');
    $this->get('/create', TestimoniesController::class . ':create')->setName('testimonies.create');
    $this->post('/create', TestimoniesController::class . ':store');
    $this->get('/edit/{slug}', TestimoniesController::class . ':edit')->setName('testimonies.edit');
    $this->get('/delete/{slug}', TestimoniesController::class . ':delete')->setName('testimonies.delete');
    $this->post('/{slug}/update', TestimoniesController::class . ':update')->setName('testimonies.update');
    $this->get('/{slug}', TestimoniesController::class . ':show')->setName('testimonies.view');
});




// #USERS
// =========================================================================

$app->group('/admin/users', function(){
    $this->get('/edit/{id}', UsersController::class . ':edit')->setName('users.edit');
    $this->post('/{id}/update', UsersController::class . ':update')->setName('users.update');
    $this->get('/{id}', UsersController::class . ':show')->setName('users.view');
});