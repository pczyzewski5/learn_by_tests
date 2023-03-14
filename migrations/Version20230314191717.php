<?php

declare(strict_types=1);

namespace learn_by_tests;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230314191717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'change sub_category column name to subcategory';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('alter table questions change sub_category subcategory varchar(36) not null;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('alter table questions change subcategory sub_category varchar(36) not null;');
    }
}
