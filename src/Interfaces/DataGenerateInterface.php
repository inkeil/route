<?php


namespace App\Route\src\Interfaces;


interface DataGenerateInterface
{

    public function addRoute($httpMethod, $routeData, $handler);


    public function getData();
}