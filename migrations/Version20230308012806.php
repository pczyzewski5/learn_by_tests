<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308012806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'change_column_answer_type';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('alter table answers modify answer mediumtext not null;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('alter table answers modify answer text not null;');
    }
}
