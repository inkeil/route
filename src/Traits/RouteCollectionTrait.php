<?php


namespace Sepia\Route\Traits;


/*模板方法*/
trait RouteCollectionTrait
{

    /**
     * http请求方式
     * @var array
     */
    public static $methods = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];


    public function get(string $path, $handler=null)
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, $handler=null){
        $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, $handler=null){
        $this->addRoute('PUT', $path, $handler);
    }

    public function patch(string $path, $handler=null){
        $this->addRoute('PATCH', $path, $handler);
    }

    public function head(string $path, $handler)
    {
        $this->addRoute('HEAD', $path, $handler);
    }

    public function delete(string $path, $handler=null){
        $this->addRoute('DELETE', $path, $handler );
    }

    public function options(string $path, $handler=null){
        $this->addRoute('OPTIONS', $path, $handler);
    }

    public function any(string $path,$handle=null){
        $this->addRoute(self::$methods,$path,$handle);
    }

    public function group($prefix,callable $callback){
        $this->addGroup($prefix,$callback);
    }

}