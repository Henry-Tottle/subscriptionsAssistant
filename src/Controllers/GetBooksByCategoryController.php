<?php

namespace App\Controllers;

use App\Models\SubscriptionsBooksModel;
use Faker\Provider\PhoneNumber;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;

class GetBooksByCategoryController
{
    private SubscriptionsBooksModel $subscriptionsBooksModel;
    private PhpRenderer $renderer;

    public function __construct(SubscriptionsBooksModel $subscriptionsBooksModel, PhpRenderer $renderer)
    {
        $this->subscriptionsBooksModel = $subscriptionsBooksModel;
        $this->renderer = $renderer;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->renderer->render($response, 'getBooksView.phtml', ['booksArray'=> $this->subscriptionsBooksModel->getBooksByCategory('FICTION')]);
    }
}