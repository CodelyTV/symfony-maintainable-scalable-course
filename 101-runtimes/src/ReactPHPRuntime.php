<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Server\RequestHandlerInterface;
use ReflectionParameter;
use Symfony\Component\Runtime\GenericRuntime;
use Symfony\Component\Runtime\RunnerInterface;

class ReactPHPRuntime extends GenericRuntime
{
    private $port;

    public function __construct(array $options)
    {
        $this->port = $options['port'] ?? 8080;
        parent::__construct($options);
    }

    public function getRunner(?object $application): RunnerInterface
    {
        if ($application instanceof RequestHandlerInterface) {
            return new ReactPHPRunner($application, $this->port);
        }

        // if it's not a PSR-15 application, use the GenericRuntime to
        // run the application (see "Resolvable Applications" above)
        return parent::getRunner($application);
    }

    protected function getArgument(ReflectionParameter $parameter, ?string $type)
    {
        if ($parameter->getName() === 'codely') {
            return 'masmola';
        }

        return parent::getArgument($parameter, $type);
    }
}
