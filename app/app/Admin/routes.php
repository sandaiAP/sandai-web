<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),

], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('points', PointsController::class);
    $router->resource('auth/staffs', StaffController::class);
    $router->resource('auth/customers', CustomerController::class);
    $router->resource('auth/pointlogs', PointLogsController::class);
    $router->get('auth/errors', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Route::get('image/{filename}', function ($filename)
{
    $path = storage_path() . '/app/image/' . $filename;

    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
