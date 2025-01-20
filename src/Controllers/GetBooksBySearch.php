<?php

namespace App\Controllers;

use App\Models\SubscriptionsBooksModel;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetBooksBySearch
{
    private SubscriptionsBooksModel $model;

    public function __construct(SubscriptionsBooksModel $model)
    {
        $this->model = $model;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $books = $this->model->getBooksBySearch('%'.$args["search"].'%', $args['qty']);
        $responseBody = [
            'message' => 'Books successfully got by search',
            'status' => 200,
            'data' => $books
        ];

        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($responseBody);
    }
}