<?php

declare(strict_types=1);

namespace DoctrineMigration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230512135958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE _sys_messenger_async (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BE08A759FB7336F0 ON _sys_messenger_async (queue_name)');
        $this->addSql('CREATE INDEX IDX_BE08A759E3BD61CE ON _sys_messenger_async (available_at)');
        $this->addSql('CREATE INDEX IDX_BE08A75916BA31DB ON _sys_messenger_async (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify__sys_messenger_async() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'_sys_messenger_async\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON _sys_messenger_async;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON _sys_messenger_async FOR EACH ROW EXECUTE PROCEDURE notify__sys_messenger_async();');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE _sys_messenger_async');
    }
}
