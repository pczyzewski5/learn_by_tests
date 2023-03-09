<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\User;

use DateTime;
use LearnByTests\Domain\User\User as DomainUser;
use LearnByTests\Domain\User\UserDTO;
use App\DateTimeNormalizer;

class UserMapper
{
    public static function toDomain(User $entity): DomainUser
    {
        $dto = new UserDTO();
        $dto->id = $entity->id;
        $dto->email = $entity->email;
        $dto->roles = \json_decode($entity->roles);
        $dto->password = $entity->password;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainUser($dto);
    }

    public static function fromDomain(
        DomainUser $domainEntity
    ): User {
        $entity = new User();
        $entity->id = $domainEntity->getId();
        $entity->email = $domainEntity->getEmail();
        $entity->roles = \json_encode($domainEntity->getRoles());
        $entity->password = $domainEntity->getPassword();
        $entity->createdAt = DateTime::createFromImmutable(
            $domainEntity->getCreatedAt()
        );

        return $entity;
    }

    /**
     * @return DomainUser[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (User $entity) => self::toDomain($entity),
            $entities
        );
    }
}
