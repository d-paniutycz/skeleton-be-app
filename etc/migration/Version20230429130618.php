<?php

declare(strict_types=1);

namespace DoctrineMigration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230429130618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE client (client_id_value VARCHAR(255) NOT NULL, client_name_value VARCHAR(255) NOT NULL, PRIMARY KEY(client_id_value))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE client');
    }
}
