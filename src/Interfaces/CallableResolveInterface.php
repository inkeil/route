<?php


namespace Sepia\Route\Interfaces;


interface CallableResolveInterface
{
    /**
     * Resolve $toResolve into a callable
     *
     * @param string|callable $toResolve
     * @return callable
     */
    public function resolve($toResolve): callable;
}