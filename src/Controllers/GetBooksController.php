<?php

namespace App\Controllers;

use App\Models\BooksModel;
use App\Models\SubscriptionsBooksModel;
use Slim\Http\Interfaces\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Slim\Views\PhpRenderer;

class GetBooksController
{

    private SubscriptionsBooksModel $subscriptionsBooksModel;


    public function __construct(SubscriptionsBooksModel $subscriptionsBooksModel)
    {
        $this->subscriptionsBooksModel = $subscriptionsBooksModel;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $books = $this->subscriptionsBooksModel->getAll($args['qty']);
        $responseBody = [
            'message' => 'Books successfully retrieved from database.',
            'status' => 200,
            'data' => $books
        ];
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($responseBody);
    }
}