<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201002142605 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick ADD banner VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER INDEX trick_slug_uindex RENAME TO UNIQ_D8F0A91E989D9B62');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE trick DROP banner');
        $this->addSql('ALTER INDEX uniq_d8f0a91e989d9b62 RENAME TO trick_slug_uindex');
    }
}
