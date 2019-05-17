<?php

use Illuminate\Routing\Router;

use \Encore\Admin\Facades\Admin;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resource('users', UserController::class);
    $router->resource('posts', PostController::class);
    $router->resource('movies', MovieController::class);
    $router->resource('directors', DirectorController::class);
});
