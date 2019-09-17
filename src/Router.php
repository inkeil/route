<?php


namespace Sepia\Route;


use FastRoute\RouteCollector;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sepia\Route\Exceptions\BadRouteException;
use Sepia\Route\Exceptions\RecordNotFoundException;
use Sepia\Route\Interfaces\CallableResolveInterface;
use Sepia\Route\Interfaces\DispatchInterface;
use Sepia\Route\Interfaces\RouteCollectionInterface;


use Sepia\Route\Interfaces\RouteParseInterface;
use Sepia\Route\Interfaces\StrategyRequestInterface;

use Sepia\Route\Strategy\RequestResponse;

use Sepia\Route\Traits\CallableResolveTrait;
use Sepia\Route\Traits\ContainerAwareTrait;
use Sepia\Route\Traits\DispatchBasedTrait;
use Sepia\Route\Traits\StrategyAwareTrait;
use Sepia\Route\Traits\RouteCollectionTrait;

use Sepia\Route\RouteParse\StringParse;
use SuperClosure\Serializer;

class Router implements RouteCollectionInterface,DispatchInterface,CallableResolveInterface
{

    use RouteCollectionTrait,StrategyAwareTrait,DispatchBasedTrait,CallableResolveTrait,ContainerAwareTrait;

    protected $routes;

    /**
     * 支持发送方式
     * @var string
     * */
    protected $method = [];

    /**
     * 路由组数据
     * @var
     */
    protected $groupStack;

    /**
     * 路由名称
     * @var null|string
     */
    protected $name;
    /**
     * 路由参数
     * @var array
     */
    protected $arguments;

    protected $container;

    protected $cacheDisabled = true;

    protected $cacheFile    = "";

    protected $callableResolve;

    protected $responseFactory;

    protected $routeParse;

    protected $route;

    protected $currentGroupPrefix;

    public function __construct(
        ?ContainerInterface $container      = null,
        ?StrategyRequestInterface $strategy = null,
        ?RouteParseInterface $routeParse    = null
    )
    {
        $this->currentGroupPrefix   = '';
        $this->strategy             = $strategy?? new RequestResponse();
        $this->routeParse           = $routeParse?? new StringParse();
        $this->container            = $container?? $container;
        $this->route                = new Route();
    }


    public function setCache($cacheFile=''){
        $this->cacheDisabled        = false;
        $this->cacheFile            = $cacheFile??$cacheFile;
    }

    public function addRoute($httpMethod, string $path, $handler)
    {
        $path  = sprintf('/%s', ltrim($path, '/'));
        $routeData = $this->routeParse->parse($path);
        foreach ((array) $httpMethod as $method) {
            foreach ($routeData as $data) {
                $this->route->addRoute($method, $data, $handler);
            }
        }

        return $this;
    }

    public function addGroup($prefix, callable $callback)
    {
        $previousGroupPrefix      = $this->currentGroupPrefix;
        $this->currentGroupPrefix = $previousGroupPrefix . $prefix;
        $callback($this);
        $this->currentGroupPrefix = $previousGroupPrefix;
    }



    public function handle(  callable $callable,
                             ServerRequestInterface $request,
                             ResponseInterface $response,
                             array $args
    ){
        $str=$this->getStrategy();
        $str($callable,$request,$response,$args);
    }
    /**
     * Returns the collected route data, as provided by the data generator.
     *
     * @return array
     */
    public function getData()
    {
        if (!$this->cacheDisabled && file_exists($this->cacheFile)) {
            $dispatchData = require $this->cacheFile;
            if (!is_array($dispatchData)) {
                throw new \RuntimeException('Invalid cache file "' . $this->cacheFile . '"');
            }
            return $dispatchData;
        }
        /** @var RouteCollector $routeCollector */
        $dispatchData = $this->route->getData();
        if (!$this->cacheDisabled) {
            file_put_contents(
                $this->cacheFile,
                '<?php return ' . var_export($dispatchData, true) . ';'
            );
        }

        return $dispatchData;
    }




    protected function dispatchVariableRoute($routeData, $uri)
    {

        foreach ($routeData as $data) {
            if (!preg_match($data['regex'], $uri, $matches)) {
                continue;
            }

            list($handler, $varNames) = $data['routeMap'][count($matches)];

            $vars = [];
            $i = 0;
            foreach ($varNames as $varName) {
                $vars[$varName] = $matches[++$i];
            }
            return [self::FOUND, $handler, $vars];
        }

        return [self::NOT_FOUND,null, []];
    }


    public function process(ServerRequestInterface $request,ResponseInterface $response)
    {

        $routeInfo = $this->dispatch($request);

        (new $routeInfo[0])($this, $routeInfo, $request, $response);

    }

}