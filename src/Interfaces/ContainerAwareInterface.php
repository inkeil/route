<?php


namespace Sepia\Route\Interfaces;


use Psr\Container\ContainerInterface;

interface ContainerAwareInterface
{
    /**
     * Get the current container
     *
     * @return ContainerInterface|null
     */
    public function getContainer(): ?ContainerInterface;


    /**
     * set current container
     * @param ContainerInterface $container
     * @return ContainerAwareInterface
     */
    public function setContainer(ContainerInterface $container): ContainerAwareInterface;
}