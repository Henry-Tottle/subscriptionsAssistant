<?php

namespace App\Controllers;

use App\Models\SubscriptionsBooksModel;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;

class GetBooksByCategoryController
{
    private SubscriptionsBooksModel $subscriptionsBooksModel;

    public function __construct(SubscriptionsBooksModel $subscriptionsBooksModel)
    {
        $this->subscriptionsBooksModel = $subscriptionsBooksModel;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, $args)
    {
        $books = $this->subscriptionsBooksModel->getBooksByCategory($args['category'], $args['qty']);
        $responseBody = [
            'message' => 'Books successfully retrieved from database by category.',
            'status' => 200,
            'data' => $books
        ];
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($responseBody);
    }
}