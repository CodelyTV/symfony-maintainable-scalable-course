<?php

declare(strict_types=1);

namespace CodelyTv\Shared\Infrastructure\Symfony;

use CodelyTv\Shared\Domain\Bus\Command\Command;
use CodelyTv\Shared\Domain\Bus\Command\CommandBus;
use CodelyTv\Shared\Domain\Bus\Query\Query;
use CodelyTv\Shared\Domain\Bus\Query\QueryBus;
use CodelyTv\Shared\Domain\Bus\Query\Response;
use Symfony\Component\Serializer\SerializerInterface;
use function Lambdish\Phunctional\each;

abstract class ApiController
{
    public function __construct(
        private QueryBus $queryBus,
        private CommandBus $commandBus,
        protected SerializerInterface $serializer,
        ApiExceptionsHttpStatusCodeMapping $exceptionHandler
    ) {
        each(
            fn(int $httpCode, string $exceptionClass) => $exceptionHandler->register($exceptionClass, $httpCode),
            $this->exceptions()
        );
    }

    abstract protected function exceptions(): array;

    protected function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
