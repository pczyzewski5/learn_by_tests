<?php

declare(strict_types=1);

namespace LearnByTests\Domain\User;

use LearnByTests\Domain\Exception\PersisterException;

interface UserPersister
{
    /**
     * @throws PersisterException
     */
    public function save(User $user): void;

    /**
     * @throws PersisterException
     */
    public function update(User $user): void;

    /**
     * @throws PersisterException
     */
    public function delete(User $user): void;
}
