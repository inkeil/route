<?php


namespace Sepia\Route\RouteAction;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sepia\Route\Interfaces\ResolveInterface;
use Sepia\Route\Router;

class MethodNotAllowedAction implements ResolveInterface
{

    public function __invoke(Router $router, $routeInfo,  ServerRequestInterface $request,ResponseInterface $response)
    {
        // TODO: Implement resolve() method.
    }

}