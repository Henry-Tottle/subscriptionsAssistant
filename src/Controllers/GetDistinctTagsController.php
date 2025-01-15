<?php

namespace App\Controllers;

use App\Models\SubscriptionsBooksModel;
use Psr\Http\Message\RequestInterface;
use Slim\Http\Interfaces\ResponseInterface;

class GetDistinctTagsController
{
    private SubscriptionsBooksModel $model;

    public function __construct(SubscriptionsBooksModel $model)
    {
        $this->model = $model;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $tags = $this->model->getTags();
        $responseBody = [
            'message' => 'Tags successfully retrieved',
            'status' => 200,
            'data' => $tags
        ];
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($responseBody);
    }
}