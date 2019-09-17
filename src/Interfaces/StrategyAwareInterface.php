<?php


namespace Sepia\Route\Interfaces;


interface StrategyAwareInterface
{
    /**
     * Get the current strategy
     *
     * @return StrategyRequestInterface
     */
    public function getStrategy(): ?StrategyRequestInterface;

    /**
     * Set the strategy implementation
     *
     * @param StrategyRequestInterface $strategy
     *
     * @return static
     */
    public function setStrategy(StrategyRequestInterface $strategy) :void ;
}