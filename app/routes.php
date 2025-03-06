<?php
declare(strict_types=1);

use App\Controllers\GetTagsController;
use Slim\App;
use Slim\Views\PhpRenderer;
use App\Controllers\GetCategoriesController;
use App\Controllers\GetBooksByID;
use App\Controllers\AddTagsController;
use App\Controllers\GetDistinctTagsController;
use App\Controllers\GetBooksBySearch;
use App\Controllers\GetAllBooksController;
use App\Controllers\ImportBooksController;
use App\Controllers\DeleteTagController;
return function (App $app) {
    $container = $app->getContainer();

    //demo code - two ways of linking urls to functionality, either via anon function or linking to a controller

    $app->get('/', function ($request, $response, $args) use ($container) {
        $renderer = $container->get(PhpRenderer::class);
        return $renderer->render($response, "index.php", $args);
    });

    $app->post('/books/actions/add-tag', AddTagsController::class);
    $app->post('/books/importBooks', importBooksController::class);
    $app->get('/books/tags', GetDistinctTagsController::class);
    $app->get('/books/search/{search}/{qty}', GetBooksBySearch::class);
    $app->get('/categories', GetCategoriesController::class);
    $app->get('/books/filter', GetAllBooksController::class);
    $app->get('/book/{id}', GetBooksByID::class);
    $app->get('/book/{id}/tags', GetTagsController::class);
    $app->delete('/delete/tags/{id}/{tag}', DeleteTagController::class);
    $app->post('/login', \App\Controllers\LoginController::class);

};
