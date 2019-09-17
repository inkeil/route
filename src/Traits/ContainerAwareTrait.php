<?php


namespace Sepia\Route\Traits;

use Psr\Container\ContainerInterface;


trait ContainerAwareTrait
{
    /**
     * @var ContainerInterface|null
     */
    protected $container;


    /**
     * @return ContainerInterface|null
     */
    public function getContainer(): ?ContainerInterface
    {
        return $this->container;
    }


    /**
     * @param ContainerInterface $container
     * @return mixed
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;

        return $this;
    }
}