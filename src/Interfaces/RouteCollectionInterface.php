<?php


namespace Sepia\Route\Interfaces;

use Sepia\Route\Route;

interface RouteCollectionInterface
{
    /**
     * Add a route to the map
     *
     * @param string|array    $method
     * @param string          $path
     * @param callable|string $handler
     *
     * @return Sepia\Route
     */
    public function addRoute($method, string $path, $handler);
    /**
     * Add a route to the map
     *
     * @param string    $prefix
     * @param callable|string $handler
     *
     * @return Sepia\Route
     */
    public function addGroup($prefix,callable $handler) ;

    /**
     * Add a route that responds to GET HTTP method
     *
     * @param string          $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function get(string $path, $handler);

    /**
     * Add a route that responds to POST HTTP method
     *
     * @param string          $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function post(string $path, $handler);

    /**
     * Add a route that responds to PUT HTTP method
     *
     * @param string          $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function put(string $path, $handler);

    /**
     * Add a route that responds to PATCH HTTP method
     *
     * @param string          $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function patch(string $path, $handler);

    /**
     * Add a route that responds to DELETE HTTP method
     *
     * @param string          $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function delete(string $path, $handler);

    /**
     * Add a route that responds to HEAD HTTP method
     *
     * @param string          $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function head(string $path, $handler);

    /**
     * Add a route that responds to OPTIONS HTTP method
     *
     * @param string          $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function options(string $path, $handler);


    /**
     * Add a route that responds to Any HTTP method
     *
     * @param string          $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function any(string $path, $handler);

}