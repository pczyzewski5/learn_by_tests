<?php

declare(strict_types=1);

namespace App\QueryBus;

interface QueryBus
{
    public function handle(object $query);
}
