<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201213501 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, publicateur_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, sous_category_id INT DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, disponibilite TINYINT(1) NOT NULL, INDEX IDX_AF3C67797FEFB0D8 (publicateur_id), INDEX IDX_AF3C6779BCF5E72D (categorie_id), INDEX IDX_AF3C6779527FEED1 (sous_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67797FEFB0D8 FOREIGN KEY (publicateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779BCF5E72D FOREIGN KEY (categorie_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779527FEED1 FOREIGN KEY (sous_category_id) REFERENCES sous_category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE publication');
    }
}
