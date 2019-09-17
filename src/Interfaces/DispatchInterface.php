<?php


namespace Sepia\Route\Interfaces;


use Psr\Http\Message\ServerRequestInterface;
use Sepia\Route\RouteAction\FoundAction;
use Sepia\Route\RouteAction\MethodNotAllowedAction;
use Sepia\Route\RouteAction\NotFoundAction;

interface DispatchInterface
{
    const NOT_FOUND = NotFoundAction::class;
    const FOUND = FoundAction::class;
    const METHOD_NOT_ALLOWED = MethodNotAllowedAction::class;

    /**
     * Dispatches against the provided HTTP method verb and URI.
     *
     * Returns array with one of the following formats:
     *
     *     [self::NOT_FOUND, null, []]
     *     [self::METHOD_NOT_ALLOWED, ['GET', 'OTHER_ALLOWED_METHODS']]
     *     [self::FOUND, $handler, ['varName' => 'value', ...]]
     *
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    public function dispatch(ServerRequestInterface $request);
}