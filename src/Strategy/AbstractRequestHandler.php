<?php


namespace Sepia\Route\Strategy;



use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sepia\Route\Interfaces\StrategyRequestInterface;

abstract class AbstractRequestHandler implements StrategyRequestInterface
{

    /** @var array */
    protected $defaultResponseHeaders = [];
    /**
     * Get current default response headers
     *
     * @return array
     */
    public function getDefaultResponseHeaders(): array
    {

        return $this->defaultResponseHeaders;

    }

    /**
     * Add or replace a default response header
     *
     * @param string $name
     * @param string $value
     *
     * @return static
     */
    public function addDefaultResponseHeader(string $name, string $value): AbstractRequestHandler
    {

        $this->defaultResponseHeaders[strtolower($name)] = $value;

        return $this;

    }

    /**
     * Add multiple default response headers
     *
     * @param array $headers
     *
     * @return static
     */
    public function addDefaultResponseHeaders(array $headers): AbstractRequestHandler
    {

        array_walk($headers,function ($value,$key){
            $this->addDefaultResponseHeader($key, $value);
        });

        return $this;

    }

    /**
     * Apply default response headers
     *
     *
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    protected function applyDefaultResponseHeaders(ResponseInterface $response): ResponseInterface
    {

        array_walk($this->defaultResponseHeaders,function ($value,$key) use (&$response) {
            $response = $this->applyDefaultResponseHeader($response,$key,$value);
        });

        return $response;

    }

    /**
     * Apply default response header
     *
     * Headers that already exist on the response will NOT be replaced.
     *
     * @param ResponseInterface $response
     *
     * @param string $key
     *
     * @param string $value
     *
     * @return ResponseInterface
     */
    protected function applyDefaultResponseHeader(ResponseInterface $response,string $key, string $value): ResponseInterface
    {

        if (false === $response->hasHeader($key)) {
            $response = $response->withHeader($key, $value);
        }
        return $response;

    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ServerRequestInterface
     */
    public function withRequestAttribute(ServerRequestInterface $request, array  $args):ServerRequestInterface
    {

        array_walk($args,function ($value,$key)use(&$request){
           $request= $request->withAttribute($key,$value);
        });

        return $request;

    }

}