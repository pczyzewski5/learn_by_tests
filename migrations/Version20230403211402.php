<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230403211402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates user_skipped_questions table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE user_skipped_questions
(
    user_id        VARCHAR(36) NOT NULL,
    question_id    VARCHAR(36) NOT NULL,
    created_at     DATETIME NOT NULL,
    UNIQUE (user_id, question_id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user_skipped_questions;');
    }
}
