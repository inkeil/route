<?php


namespace Sepia\Route\Traits;


use Sepia\Route\Interfaces\StrategyRequestInterface;


trait StrategyAwareTrait
{

    protected $strategy;


    public function getStrategy() :StrategyRequestInterface
    {

        return $this->strategy;

    }



    public function setStrategy(StrategyRequestInterface $strategy)
    {

        $this->strategy = $strategy;

    }


}