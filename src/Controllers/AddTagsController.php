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
//        if ($request->getMethod() === 'OPTIONS') {
//            return $response
//                ->withHeader('Access-Control-Allow-Origin', '*') // Allow all origins (you can restrict it to specific domains)
//                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
//                ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
//                ->withHeader('Access-Control-Allow-Credentials', 'true')
//                ->withStatus(200);
//        }


        if ($request->getMethod() === 'POST') {
            $body = $request->getBody()->getContents();
            $data = json_decode($body, true);
            $tag = $data['tag'] ?? null;
            $id = $data['book_id'] ?? null;
            if (!$tag || !$id) {
                $errorResponse = [
                    'message' => 'Invalid input. "tag" and "book_id" are required',
                    'status' => 400
                ];
                return $response->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400)
                    ->withJson($errorResponse);
            }

            $this->model->addTag($id, $tag);

            $responseBody = [
                'message' => 'Tag successfully added',
                'status' => 201,
                'tag' => $tag
            ];

            return $response->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Content-Type', 'application/json')
//                ->withHeader('Access-Control-Allow-Credentials', 'true')
                ->withStatus(201)
                ->withJson($responseBody);
        }

        $errorResponse = [
            'message' => 'Method not allowed',
            'status' => 405
        ];

        return $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(405)
            ->withJson($errorResponse);


    }
}