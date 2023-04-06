<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406203230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add index in user_skipped_questions table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'create index user_skipped_questions_question_id_index on user_skipped_questions (question_id);'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'drop index user_skipped_questions_question_id_index on user_skipped_questions;'
        );
    }
}
