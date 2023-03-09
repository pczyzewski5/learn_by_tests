<?php

declare(strict_types=1);

namespace LearnByTests\Domain\User\Exception;

use LearnByTests\Domain\Exception\ValidationException;

class UserAlreadyExistsException extends ValidationException
{

}
