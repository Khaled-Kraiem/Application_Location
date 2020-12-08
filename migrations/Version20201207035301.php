<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201207035301 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE caddy_publication');
        $this->addSql('ALTER TABLE caddy ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE caddy ADD CONSTRAINT FK_FCBC6E21F347EFB FOREIGN KEY (produit_id) REFERENCES publication (id)');
        $this->addSql('CREATE INDEX IDX_FCBC6E21F347EFB ON caddy (produit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE caddy_publication (caddy_id INT NOT NULL, publication_id INT NOT NULL, INDEX IDX_94BFA41738B217A7 (publication_id), INDEX IDX_94BFA41766675095 (caddy_id), PRIMARY KEY(caddy_id, publication_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE caddy_publication ADD CONSTRAINT FK_94BFA41738B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE caddy_publication ADD CONSTRAINT FK_94BFA41766675095 FOREIGN KEY (caddy_id) REFERENCES caddy (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE caddy DROP FOREIGN KEY FK_FCBC6E21F347EFB');
        $this->addSql('DROP INDEX IDX_FCBC6E21F347EFB ON caddy');
        $this->addSql('ALTER TABLE caddy DROP produit_id');
    }
}
