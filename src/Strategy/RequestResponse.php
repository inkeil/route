<?php


namespace Sepia\Route\Strategy;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sepia\Route\Traits\ContainerAwareTrait;

class RequestResponse extends AbstractRequestHandler
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

        $response= $callable($this->withRequestAttribute($request,$args),$response,$args);
        if(!$response instanceof ResponseInterface){
            throw new \BadMethodCallException('Illegal request information');
        }
        return $this->applyDefaultResponseHeaders($response);

    }





}