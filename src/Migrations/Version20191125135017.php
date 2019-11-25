<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191125135017 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create entities';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("
            CREATE TABLE hotel(
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(127) NOT NULL,
                address VARCHAR(512) NOT NULL,
                rooms INT UNSIGNED NOT NULL DEFAULT 0,
                chain_id INT NOT NULL DEFAULT 0,
                uuid varchar(63)  NOT NULL
            );
        ");
        $this->addSql('CREATE INDEX uuid_idx ON hotel(uuid);');
        $this->addSql("
            CREATE TABLE hotel_chain(
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(127) NOT NULL
            );
        ");
        $this->addSql("
            CREATE TABLE review(
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                hotel_id INT NOT NULL DEFAULT 0,
                text TEXT NOT NULL,
                score TINYINT UNSIGNED NOT NULL DEFAULT 0,
                date DATETIME NOT NULL
            );
        ");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DROP TABLE review;");
        $this->addSql("DROP TABLE hotel_chain;");
        $this->addSql('DROP INDEX uuid_idx ON hotel;');
        $this->addSql("DROP TABLE hotel;");
    }
}
