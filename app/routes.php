<?php
declare(strict_types=1);

use App\Controllers\GetTagsController;
use Slim\App;
use Slim\Views\PhpRenderer;
use App\Controllers\GetBooksController;
use App\Controllers\GetBooksByCategoryController;
use App\Controllers\GetCategoriesController;
use App\Controllers\GetBooksByID;
use App\Controllers\AddTagsController;
use App\Controllers\GetBooksByTagController;
use App\Controllers\GetDistinctTagsController;
use App\Controllers\GetBooksBySearch;
use App\Controllers\GetAllBooksController;
use App\Controllers\ImportBooksController;
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
    $app->get('/books/{qty}/[format]', GetBooksController::class);
    $app->get('/books/tags/{tag}', GetBooksByTagController::class);
    $app->get('/books/category/{category}/{qty}', GetBooksByCategoryController::class);
    $app->get('/book/{id}', GetBooksByID::class);
    $app->get('/book/{id}/tags', GetTagsController::class);

    //does this count as a change?
};
