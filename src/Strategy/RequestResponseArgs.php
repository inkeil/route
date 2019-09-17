<?php


namespace Sepia\Route\Strategy;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sepia\Route\Traits\ContainerAwareTrait;

class RequestResponseArgs extends AbstractRequestHandler
{
    use ContainerAwareTrait;
    /**
     * @param callable $callable
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface
    {

       $response= $callable($this->withRequestAttribute($request,$args),$response,...array_values($args));

       return $this->applyDefaultResponseHeaders($response);

    }

}