<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406203422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'adds index in user_question_answers table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'create index user_question_answers_question_id_index on user_question_answers (question_id);'
        );
    }

    public function down(Schema $schema): void
    {
       $this->addSql(
           'drop index user_question_answers_question_id_index on user_question_answers;'
       );
    }
}
