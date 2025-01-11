<?php
declare(strict_types=1);

use Slim\App;
use Slim\Views\PhpRenderer;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Controllers\GetBooksController;
use App\Controllers\GetBooksByCategoryController;
use App\Controllers\GetCategoriesController;
use App\Controllers\GetBooksByID;
use App\Controllers\AddTagsController;
return function (App $app) {
    $container = $app->getContainer();

    //demo code - two ways of linking urls to functionality, either via anon function or linking to a controller

    $app->get('/', function ($request, $response, $args) use ($container) {
        $renderer = $container->get(PhpRenderer::class);
        return $renderer->render($response, "index.php", $args);
    });

    $app->get('/books', GetBooksController::class);
    $app->get('/books/{category}', GetBooksByCategoryController::class);
    $app->get('/categories', GetCategoriesController::class);
    $app->get('/book/{id}', GetBooksByID::class);
    $app->post('/books/add-tag', AddTagsController::class);
};
