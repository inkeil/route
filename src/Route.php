<?php


namespace Sepia\Route;


use ArrayAccess;
use InvalidArgumentException;
use LogicException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionFunctionAbstract;
use ReflectionMethod;
use ReflectionParameter;
use Sepia\Route\Traits\CallableResolveTrait;
use Sepia\Route\Traits\RegexBasedTrait;
use Sepia\Route\Traits\StrategyAwareTrait;
use SuperClosure\Serializer;

class Route
{

    use StrategyAwareTrait,CallableResolveTrait, RegexBasedTrait;

    protected $router;


    protected $container;


    protected $action;

    protected $uri;

    protected $methods;

    protected $responseFactory;


    protected $strategy;


    protected $callableResolve;


    protected $regex;


    protected function getApproxChunkSize()
    {
        return 10;
    }

    protected function processChunk($regexToRoutesMap)
    {
        $routeMap = [];
        $regexes = [];
        $numGroups = 0;
        foreach ($regexToRoutesMap as $regex => $route) {
            $numVariables = count($route->variables);
            $numGroups = max($numGroups, $numVariables);

            $regexes[] = $regex . str_repeat('()', $numGroups - $numVariables);
            $routeMap[$numGroups + 1] = [$route->handler, $route->variables];

            ++$numGroups;
        }

        $regex = '~^(?|' . implode('|', $regexes) . ')$~';
        return ['regex' => $regex, 'routeMap' => $routeMap];
    }


}