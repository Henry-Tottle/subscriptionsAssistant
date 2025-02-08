<?php

namespace App\Controllers;

use App\Models\SubscriptionsBooksModel;
use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ImportBooksController
{
    private SubscriptionsBooksModel $model;

    public function __construct(SubscriptionsBooksModel $model)
    {
        $this->model = $model;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($request->getMethod() === "POST")
        {
            $body = $request->getBody()->getContents();
            $data = json_decode($body, true);
            if(!is_array($data)){

                throw new Exception("JSON decode error", 1);
            }

            $this->model->importBooks($data['books']);

            $responseBody = ['message' => "Books imported successfully",
                'status' => 201];

            return $response->withHeader('access-control-allow-origin', '*')->withStatus(201)->withJson($responseBody);

        }

        $errorResponse = [
            'message' => "Invalid request",
            'status' => 400
        ];

        return $response->withHeader('access-control-allow-origin', '*')->withStatus(400)->withJson($errorResponse);
    }
}