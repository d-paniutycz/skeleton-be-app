<?php

declare(strict_types=1);

namespace DoctrineMigration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use RuntimeException;

final class Version20230427134418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create read only role and user';
    }

    public function up(Schema $schema): void
    {
        $role = 'read_only_role';

        // env variables are loaded mostly trough dotenv, getenv() will not work as expected
        $database = $_ENV['DMS_PG1_DATABASE'] ?? null;
        $username = $_ENV['DMS_PG1_REP_USERNAME'] ?? null;
        $password = $_ENV['DMS_PG1_REP_PASSWORD'] ?? null;

        if (!$database || !$username || !$password) {
            throw new RuntimeException('Some env variables are missing');
        }

        $this->addSql("CREATE ROLE $role");
        $this->addSql("GRANT USAGE ON SCHEMA public TO $role");
        $this->addSql("GRANT SELECT ON ALL TABLES IN SCHEMA public TO $role");
        $this->addSql("ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT SELECT ON TABLES TO $role");
        $this->addSql("CREATE USER $username WITH PASSWORD '$password'");
        $this->addSql("GRANT $role TO $username");
    }

    public function down(Schema $schema): void
    {
        // env variables might be already changed at this point
        throw new RuntimeException('No way back');
    }
}
