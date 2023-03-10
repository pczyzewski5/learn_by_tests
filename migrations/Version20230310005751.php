<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310005751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add author_id column to questions table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('alter table questions add author_id varchar(36) not null after question;');

    }

    public function down(Schema $schema): void
    {
       $this->addSql('alter table questions drop column author_id;');
    }
}
