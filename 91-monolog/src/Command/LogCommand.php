<?php

declare(strict_types=1);

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LogCommand extends Command
{
    protected static $defaultName = 'app:logs';

    public function __construct(private LoggerInterface $logger)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->logger->warning('Warning from Console!');

        return Command::SUCCESS;
    }
}