<?php
declare(strict_types=1);

use App\Controllers\CoursesAPIController;
use Slim\App;
use Slim\Views\PhpRenderer;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Controllers\GetBooksController;
return function (App $app) {
    $container = $app->getContainer();

    //demo code - two ways of linking urls to functionality, either via anon function or linking to a controller

    $app->get('/', function ($request, $response, $args) use ($container) {
        $renderer = $container->get(PhpRenderer::class);
        return $renderer->render($response, "index.php", $args);
    });

    $app->get('/books', GetBooksController::class);
    $app->get('/courses', CoursesAPIController::class);
    $app->get('/books/FICTION', \App\Controllers\GetBooksByCategoryController::class);

};
