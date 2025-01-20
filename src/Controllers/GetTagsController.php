<?php

namespace App\Controllers;

use App\Models\SubscriptionsBooksModel;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetTagsController
{
    private SubscriptionsBooksModel $model;

    public function __construct(SubscriptionsBooksModel $model)
    {
        $this->model = $model;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $tags = $this->model->getTagsByBookID($args["id"]);
        $responseBody = [
            'message' => 'Tags successfully retrieved',
            'status' => 200,
            'data' => $tags
        ];
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($responseBody);
    }
}