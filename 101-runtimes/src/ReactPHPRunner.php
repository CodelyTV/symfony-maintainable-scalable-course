<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use React\EventLoop\Factory as ReactFactory;
use React\Http\Server as ReactHttpServer;
use React\Socket\Server as ReactSocketServer;
use Symfony\Component\Runtime\RunnerInterface;

class ReactPHPRunner implements RunnerInterface
{
    private $application;
    private $port;

    public function __construct(RequestHandlerInterface $application, int $port)
    {
        $this->application = $application;
        $this->port = $port;
    }

    public function run(): int
    {
        $application = $this->application;
        $loop = ReactFactory::create();

        // configure ReactPHP to correctly handle the PSR-15 application
        $server = new ReactHttpServer(
            $loop,
            function (ServerRequestInterface $request) use ($application) {
                return $application->handle($request);
            }
        );

        // start the ReactPHP server
        $socket = new ReactSocketServer($this->port, $loop);
        $server->listen($socket);

        $loop->run();

        return 0;
    }
}