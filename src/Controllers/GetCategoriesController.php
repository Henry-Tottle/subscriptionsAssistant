<?php

namespace App\Controllers;

use App\Models\SubscriptionsBooksModel;
use Psr\Http\Message\RequestInterface;
use Slim\Http\Interfaces\ResponseInterface;

class GetCategoriesController
{
    private SubscriptionsBooksModel $subscriptionsBooksModel;

    public function __construct(SubscriptionsBooksModel $subscriptionsBooksModel)
    {
        $this->subscriptionsBooksModel = $subscriptionsBooksModel;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $categories = $this->subscriptionsBooksModel->getCategories();
        $responseBody = [
            'message' => 'Categories successfully retrieved',
            'statusCode' => 200,
            'data' => $categories
        ];
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($responseBody);
    }
}