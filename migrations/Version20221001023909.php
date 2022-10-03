<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221001023909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE hash_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE hash (id INT NOT NULL, batch TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, block_number INT NOT NULL, input VARCHAR(34) NOT NULL, key VARCHAR(8) NOT NULL, generated_hash VARCHAR(34) NOT NULL, number_of_attempts INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE hash_id_seq CASCADE');
        $this->addSql('DROP TABLE hash');
    }
}
