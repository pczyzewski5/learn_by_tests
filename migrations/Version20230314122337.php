<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230314122337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add sub_category column to questions table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('alter table questions add sub_category varchar(36) not null after category;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('alter table questions drop column sub_category;');
    }
}
