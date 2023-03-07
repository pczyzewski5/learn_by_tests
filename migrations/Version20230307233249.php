<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230307233249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create answers table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE answers
(
    id             VARCHAR(36) NOT NULL,
    question_id    VARCHAR(36) NOT NULL,
    answer         TEXT NOT NULL,
    is_correct     BOOLEAN NOT NULL,
    created_at     DATETIME NOT NULL,
    UNIQUE (id)
) DEFAULT CHARACTER SET UTF8
  COLLATE 'UTF8_unicode_ci';
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE answers;');
    }
}
