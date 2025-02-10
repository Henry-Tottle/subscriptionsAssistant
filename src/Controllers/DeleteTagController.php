<?php

namespace App\Controllers;

use App\Models\SubscriptionsBooksModel;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
class DeleteTagController
{
    protected SubscriptionsBooksModel $model;

    public function __construct(SubscriptionsBooksModel $model)
    {
        $this->model = $model;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = isset($args["id"]) ? (int) trim($args["id"]) : null;
        $tag = isset($args["tag"]) ? (string) trim($args["tag"]) : null;
        $tag = trim($tag);

        if (!$id || !$tag)
        {
            $errorResponse = [
                'error' => 'Invalid request',
                'status' => 400,
                'details' => "id is: $id, tag is: $tag"
            ];
           return $response->withHeader('Access-Control-Allow-Origin', '*')
               ->withHeader('Content-Type', 'application/json')
               ->withStatus(400)
               ->withJson($errorResponse);

        }

        try{
            $deleted = $this->model->deleteTag($id, $tag);
            if(!$deleted) {
                $errorResponse = [
                    'error' => 'Tag not found or not deleted',
                    'status' => 400,
                    'details' => "id is: $id, tag is: $tag",
                    'types' => "id type: " .gettype($id) . " , tag is: " .gettype($tag)
                ];
                return $response->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400)
                    ->withJson($errorResponse);
            }

            $responseBody = [
                'message' => 'Tag deleted successfully',
                'status' => 200,
                'data' => "$tag deleted successfully from $id"
            ];
            return $response->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200)
                ->write(json_encode($responseBody));
        } catch (\PDOException $e) {
            $errorResponse = [
                'error' => 'Server error',
                'status' => 500,
                'detail' => $e->getMessage()
            ];
            return $response->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500)
                ->withJson($errorResponse);
        }
    }
}