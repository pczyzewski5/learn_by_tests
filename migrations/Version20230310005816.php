<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310005816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add author_id column to answers table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('alter table answers add author_id varchar(36) not null after answer;');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('alter table answers drop column author_id;');
    }
}
