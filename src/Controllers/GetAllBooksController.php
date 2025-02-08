<?php

namespace App\Controllers;

use App\Models\SubscriptionsBooksModel;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetAllBooksController
{
    private $model;

    public function __construct(SubscriptionsBooksModel $model)
    {
        $this->model = $model;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, $args)
    {
        $tags = $request->getQueryParams()['tags'] ?? null;
        $format = $request->getQueryParams()['format'] ?? null;
        $limit = $request->getQueryParams()['limit'] ?? null;
        $sort = $request->getQueryParams()['sort'] ?? null;
        $sortOrder = $request->getQueryParams()['sortOrder'] ?? null;

        $tagsArray = $tags ? explode(',', $tags) : [];

        $books = $this->model->getAllBooks($tagsArray, $format, $limit, $sort, $sortOrder);

        $responseBody = [
            'message' => 'Books successfully retrieved from database',
            'status' => 200,
            'data' => $books
        ];

        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($responseBody);


    }
}