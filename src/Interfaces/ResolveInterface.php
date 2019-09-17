<?php


namespace Sepia\Route\Interfaces;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sepia\Route\Router;

interface ResolveInterface
{

    /**
     * @param Router $router
     * @param $routeInfo
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return mixed
     */
    public function __invoke(Router $router, $routeInfo, ServerRequestInterface $request,ResponseInterface $response);
}