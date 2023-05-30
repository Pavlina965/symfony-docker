<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530173007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaulation DROP CONSTRAINT fk_c5bc2f3b7294869c');
        $this->addSql('DROP TABLE evaulation');
        $this->addSql('ALTER TABLE article DROP votes');
        $this->addSql('ALTER TABLE article DROP evaulation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE evaulation (id INT NOT NULL, article_id INT DEFAULT NULL, evaulations BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_c5bc2f3b7294869c ON evaulation (article_id)');
        $this->addSql('ALTER TABLE evaulation ADD CONSTRAINT fk_c5bc2f3b7294869c FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article ADD votes INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD evaulation INT DEFAULT NULL');
    }
}
