<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230324103243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates user_test_results table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE user_test_results
(
    user_id        VARCHAR(36) NOT NULL,
    question_id    VARCHAR(36) NOT NULL,
    answered_correct     BOOLEAN NOT NULL,
    created_at     DATETIME NOT NULL,
    UNIQUE (user_id, question_id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user_test_results;');
    }
}
