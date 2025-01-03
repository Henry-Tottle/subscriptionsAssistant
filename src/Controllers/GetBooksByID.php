<?php

namespace App\Controllers;

use App\Models\SubscriptionsBooksModel;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetBooksByID
{
    private SubscriptionsBooksModel $booksModel;

    public function __construct(SubscriptionsBooksModel $booksModel)
    {
        $this->booksModel = $booksModel;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args)
    {
        $books = $this->booksModel->getBooksByID($args["id"]);
        $responseBody = [
            'message' => ' Book successfully retrieved from database by ID.',
            'status' => 200,
            'data' => $books
        ];
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($responseBody);
    }
}