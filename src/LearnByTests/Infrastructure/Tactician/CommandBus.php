<?php

declare(strict_types=1);

namespace DND\Infrastructure\Tactician;

use App\CommandBus\CommandBus as CommandBusInterface;
use League\Tactician\CommandBus as TacticianCommandBus;

class CommandBus implements CommandBusInterface
{
    private TacticianCommandBus $commandBus;

    public function __construct(TacticianCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(object $command)
    {
        return $this->commandBus->handle($command);
    }
}
