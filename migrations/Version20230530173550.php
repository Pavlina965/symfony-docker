<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530173550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE votes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE votes (id INT NOT NULL, article_id INT NOT NULL, up_vote INT NOT NULL, down_vote INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_518B7ACF7294869C ON votes (article_id)');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACF7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE votes_id_seq CASCADE');
        $this->addSql('ALTER TABLE votes DROP CONSTRAINT FK_518B7ACF7294869C');
        $this->addSql('DROP TABLE votes');
    }
}
