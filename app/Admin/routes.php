<?php

use App\Admin\Controllers\CourseTypeController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('/users', UserController::class);
    $router->resource('/course-types', CourseTypeController::class);
    $router->resource('/courses', CourseController::class);
    $router->resource('/orders', OrderController::class);
    $router->resource('/lessons', LessonController::class);
});
