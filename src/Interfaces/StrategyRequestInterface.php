<?php


namespace Sepia\Route\Interfaces;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface StrategyRequestInterface
{



    public function __invoke(callable  $callable, ServerRequestInterface $request, ResponseInterface $response, array $args ):ResponseInterface;


    public function withRequestAttribute(ServerRequestInterface $request, array $args):ServerRequestInterface;

}