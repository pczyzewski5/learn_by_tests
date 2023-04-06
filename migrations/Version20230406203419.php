<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406203419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add index in answers table';
    }

    public function up(Schema $schema): void
    {
       $this->addSql(
           'create index answers_question_id_index on answers (question_id);'
       );
    }

    public function down(Schema $schema): void
    {
       $this->addSql(
           'drop index answers_question_id_index on answers;'
       );
    }
}
