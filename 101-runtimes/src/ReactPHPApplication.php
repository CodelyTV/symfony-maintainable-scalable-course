<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use React\Http\Message\Response;

final class ReactPHPApplication implements RequestHandlerInterface
{
    public function __construct(private string $codely)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(200, [], $this->codely);
    }
};