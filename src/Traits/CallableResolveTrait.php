<?php


namespace Sepia\Route\Traits;


use Closure;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;


trait CallableResolveTrait
{

    public function resolve($callable):callable {
        // Use the default analyzer.
        if(is_callable($callable)){
            $callable = $this->bindToContainer($callable);
        }

        if (is_string($callable) && strpos($callable, '@') !== false) {
            $callable = explode('@', $callable);
        }

        if (is_array($callable) && isset($callable[0]) && is_object($callable[0])) {
            $callable = [$callable[0], $callable[1]];
        }

        if (is_array($callable) && isset($callable[0]) && is_string($callable[0])) {
            $callable = [$this->resolveClass($callable[0]), $callable[1]];
        }


        if (is_string($callable) && method_exists($callable, '__invoke')) {
            $callable = $this->resolveClass($callable);
        }

        if (! is_callable($callable)) {
            throw new InvalidArgumentException('Could not resolve a callable for this route');
        }

        return $callable;

    }

    /**
     * @param callable $callable
     *
     * @return callable
     */
    private function bindToContainer(callable $callable): callable
    {

        if ($this->container instanceof ContainerInterface && $callable instanceof Closure) {
            $callable = $callable->bindTo($this->container);
        }

        return $callable;

    }

    private  function resolveClass(string $class)
    {

        if ($this->container instanceof ContainerInterface && $this->container->has($class)) {
            return $this->container->get($class);
        }

        return new $class();
    }


}