<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211101203805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create emoji tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE emoji_category 
                        (
                            id INT AUTO_INCREMENT NOT NULL, 
                            name VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, 
                            UNIQUE INDEX emoji_category_name_uindex (name),
                            PRIMARY KEY(id)) 
                            DEFAULT CHARACTER SET utf8 
                            COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = 'Emoji categories'");

        $this->addSql('CREATE TABLE emoji
                        (
                            id       INT AUTO_INCREMENT PRIMARY KEY,
                            name     VARCHAR(50) CHARSET latin1 NOT NULL,
                            html     VARCHAR(10) CHARSET latin1 NOT NULL,
                            category_id INT                        NULL,
                            CONSTRAINT emoji_emoji_category_id_fk
                                FOREIGN KEY (category_id) REFERENCES emoji_category (id)
                        )
                        COLLATE = utf8_unicode_ci;
         ');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE emoji');
        $this->addSql('DROP TABLE emoji_category');
    }
}
