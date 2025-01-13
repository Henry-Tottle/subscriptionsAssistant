<?php

namespace App\Controllers;

use App\Models\SubscriptionsBooksModel;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AddTagsController
{
    private SubscriptionsBooksModel $model;

    public function __construct(SubscriptionsBooksModel $model)
    {
        $this->model = $model;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($request->getMethod() === 'OPTIONS') {
            return $response
                ->withHeader('Access-Control-Allow-Origin', 'http://localhost:5173') // Allow all origins (you can restrict it to specific domains)
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
                ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                ->withHeader('Access-Control-Allow-Credentials', 'true')
                ->withStatus(200);
        }

        $data = $request->getParsedBody();
        $tag = $data['tag'];
        $id = $data['book_id'];

        $this->model->addTag($id, $tag);

        $responseBody = [
            'message' => 'Tag successfully added',
            'status' => 201,
            'tag' => $tag
        ];
        $this->model->addTag($id ,$tag);
        return $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:5173')
                        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
                        ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                        ->withHeader('Access-Control-Allow-Credentials', 'true')
                        ->withJson($responseBody);
    }
}