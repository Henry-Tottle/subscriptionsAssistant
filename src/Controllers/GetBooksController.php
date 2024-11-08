<?php

namespace App\Controllers;

use App\Models\BooksModel;
use App\Models\SubscriptionsBooksModel;
use Slim\Http\Interfaces\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Slim\Views\PhpRenderer;

class GetBooksController
{

    private SubscriptionsBooksModel $subscriptionsBooksModel;

    private PhpRenderer $renderer;

    public function __construct(SubscriptionsBooksModel $subscriptionsBooksModel, PhpRenderer $renderer)
    {
        $this->subscriptionsBooksModel = $subscriptionsBooksModel;
        $this->renderer = $renderer;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->renderer->render($response, 'getBooksView.phtml', ['booksArray' => $this->subscriptionsBooksModel->getAll()]);
    }
}