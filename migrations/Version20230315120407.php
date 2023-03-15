<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315120407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add comment column to answer table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('alter table answers add comment mediumtext null after answer;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('alter table answers drop column comment;');
    }
}
