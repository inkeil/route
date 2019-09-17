<?php


namespace Sepia\Route\RouteAction;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sepia\Route\Interfaces\ResolveInterface;
use Sepia\Route\Router;
use SuperClosure\Serializer;

class FoundAction implements ResolveInterface
{

    public function __invoke(Router $router,$routeInfo,ServerRequestInterface $request,ResponseInterface $response)
    {
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $serializer = new Serializer();
        if($handler['type']=='callable'){
            $handler = $serializer->unserialize($handler['handler']);
        }else{
            $handler = $handler['handler'];
        }
        $callable=$router->resolve($handler);

        return $router->handle($callable,$request,$response,$vars);

    }

}