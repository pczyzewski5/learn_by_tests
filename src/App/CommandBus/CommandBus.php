<?php

declare(strict_types=1);

namespace App\CommandBus;

interface CommandBus
{
    public function handle(object $command);
}
