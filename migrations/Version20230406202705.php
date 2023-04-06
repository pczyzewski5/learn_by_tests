<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406202705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'adds indexes in questions table';
    }

    public function up(Schema $schema): void
    {
       $this->addSql('
                    create index questions_category_index on questions (category);
                    create index questions_subcategory_index on questions (subcategory);
                    create index questions_to_review_index on questions (to_review);
                    create index questions_created_at_index on questions (created_at);
                    ');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('
                    drop index questions_category_index on questions;
                    drop index questions_subcategory_index on questions;
                    drop index questions_to_review_index on questions;
                    drop index questions_created_at_index on questions;
                    ');
    }
}
