<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404192533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'adds to_review column into questions table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('alter table questions add to_review tinyint(1) default 0 not null after subcategory;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('alter table questions drop column to_review;');
    }
}
