<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211017134138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE user (
                id         INT AUTO_INCREMENT NOT NULL,
                email      VARCHAR(255)       NOT NULL,
                username   VARCHAR(255)       NOT NULL,
                created_at DATETIME           NOT NULL DEFAULT NOW(),
                PRIMARY KEY(id)
            )"
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user');
    }
}
