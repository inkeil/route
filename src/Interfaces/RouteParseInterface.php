<?php


namespace Sepia\Route\Interfaces;


interface RouteParseInterface
{

    /**
    *
    * @param string $route Route string to parse
    *
    * @return mixed[][] Array of route data arrays
    */
    public function parse($route);

}