<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309191603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add is_active column to users';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('alter table users add is_active boolean not null after password;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('alter table users drop column is_active;');
    }
}
