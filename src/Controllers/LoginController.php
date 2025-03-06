<?php

namespace App\Controllers;

use App\Models\SubscriptionsBooksModel;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LoginController
{
    private SubscriptionsBooksModel $model;
    public function __construct(SubscriptionsBooksModel $model)
    {
        $this->model = $model;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, $args)
    {
        $data = $request->getParsedBody();

        if (!isset($data['username'], $data['password'])) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Username or password is incorrect'
            ]));
            return $response->withStatus(400)->withJson($response);
        }
        $username = trim($data['username']);
        $password = $data['password'];

        $authorization = $this->model->login($username, $password);

        $responseData = [
            'success' => $authorization,
            'message' => $authorization ? 'Login successful' : 'Login failed'
        ];
        $response->getBody()->write(json_encode($responseData));
        return $response->withStatus($authorization ? 200 : 401)->withHeader('Content-Type', 'application/json');
    }
}