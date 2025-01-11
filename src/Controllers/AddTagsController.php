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
        $data = $request->getParsedBody();
        $tag = $data['tag'];
        $id = $data['book_id'];
        $responseBody = [
            'message' => 'Tag successfully added',
            'status' => 201,
            'tag' => $tag
        ];
        $this->model->addTag($id ,$tag);
        return $response->withHeader('Access-Control-Allow-Origin', '*')->withJson($responseBody);
    }
}