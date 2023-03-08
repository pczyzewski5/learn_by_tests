<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308013701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'change_column_question_type';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('alter table questions modify question mediumtext not null;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('alter table questions modify question text not null;');
    }
}
