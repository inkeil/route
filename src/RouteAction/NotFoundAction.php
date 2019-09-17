<?php


namespace Sepia\Route\RouteAction;


use Closure;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sepia\Route\Interfaces\ResolveInterface;
use Sepia\Route\Router;

class NotFoundAction implements ResolveInterface
{

    public function __invoke(Router $router, $routeInfo,  ServerRequestInterface $request,ResponseInterface $response)
    {

    }


}