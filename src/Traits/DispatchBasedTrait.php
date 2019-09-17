<?php


namespace Sepia\Route\Traits;


use Psr\Http\Message\ServerRequestInterface;

trait DispatchBasedTrait
{

    /** @var mixed[][] */
    protected $staticRouteMap = [];

    /** @var mixed[] */
    protected $variableRouteData = [];
    /**
     * @var array
     */
    private $allowedMethods = [];
    /**
     * @param $routeData
     * @param $uri
     * @return mixed
     */
    abstract protected function dispatchVariableRoute($routeData, $uri);

    public function dispatch(ServerRequestInterface $request)
    {
        $httpMethod = $request->getMethod();
        $uri        = $request->getUri()->getPath();

        list($this->staticRouteMap, $this->variableRouteData)=$this->getData();
        if (isset($this->staticRouteMap[$httpMethod][$uri])) {
            return [self::FOUND, $this->staticRouteMap[$httpMethod][$uri], []];
        }

        $varRouteData = $this->variableRouteData;
        if (isset($varRouteData[$httpMethod])) {
            $result = $this->dispatchVariableRoute($varRouteData[$httpMethod], $uri);
            $routingResults = $this->routingResultsFromVariableRouteResults($result);
            if ($routingResults[0] === self::FOUND) {
                return $routingResults;
            }
        }

        // For HEAD requests, attempt fallback to GET
        if ($httpMethod === 'HEAD') {
            if (isset($this->staticRouteMap['GET'][$uri])) {
                return [self::FOUND, $this->staticRouteMap['GET'][$uri], []];
            }
            if (isset($varRouteData['GET'])) {
                $result = $this->dispatchVariableRoute($varRouteData['GET'], $uri);
                return $this->routingResultsFromVariableRouteResults($result);
            }
        }

        // If nothing else matches, try fallback routes
        if (isset($this->staticRouteMap['*'][$uri])) {
            return [self::FOUND, $this->staticRouteMap['*'][$uri], []];
        }

        if (isset($varRouteData['*'])) {
            $result = $this->dispatchVariableRoute($varRouteData['*'], $uri);
            return $this->routingResultsFromVariableRouteResults($result);
        }

        $allowedMethods= $this->getAllowedMethods($uri, $httpMethod);
        // If there are no allowed methods the route simply does not exist
        if (count($allowedMethods)) {
            return [self::METHOD_NOT_ALLOWED, $allowedMethods, []];
        }

        return [self::NOT_FOUND,null, []];
    }

    /**
     * @param array $result
     * @return array
     */
    protected function routingResultsFromVariableRouteResults(array $result): array
    {
        if ($result[0] === self::FOUND) {
            return [self::FOUND, $result[1], $result[2]];
        }
        return [self::NOT_FOUND, null, []];
    }
    /**
     * @param string $uri
     * @param string $httpMethod
     * @return array
     */
    public function getAllowedMethods(string $uri, string $httpMethod): array
    {
        if (isset($this->allowedMethods[$uri])) {
            return $this->allowedMethods[$uri];
        }

        $this->allowedMethods[$uri] = [];
        foreach ($this->staticRouteMap as $method => $uriMap) {
            if ($method !== $httpMethod && isset($uriMap[$uri])) {
                $this->allowedMethods[$uri][] = $method;
            }
        }

        $varRouteData = $this->variableRouteData;
        foreach ($varRouteData as $method => $routeData) {
            $result = $this->dispatchVariableRoute($routeData, $uri);
            if ($result[0] === self::FOUND) {
                $this->allowedMethods[$uri][] = $method;
            }
        }

        return $this->allowedMethods[$uri];
    }

}