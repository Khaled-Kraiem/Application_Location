<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201207013231 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE caddy (id INT AUTO_INCREMENT NOT NULL, locateur_id INT DEFAULT NULL, produit VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, INDEX IDX_FCBC6E21411086F1 (locateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE caddy ADD CONSTRAINT FK_FCBC6E21411086F1 FOREIGN KEY (locateur_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE caddy');
    }
}
