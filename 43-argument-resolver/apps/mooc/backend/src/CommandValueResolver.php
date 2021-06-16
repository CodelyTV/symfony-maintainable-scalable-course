<?php

declare(strict_types=1);

namespace CodelyTv\Apps\Mooc\Backend;

use CodelyTv\Shared\Domain\Bus\Command\Command;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

final class CommandValueResolver implements ArgumentValueResolverInterface
{
    public function __construct(private SerializerInterface $serializer)
    {
    }
    
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return is_subclass_of($argument->getType(), Command::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield $this->serializer->deserialize($request->getContent(), $argument->getType(), 'json');
    }
}