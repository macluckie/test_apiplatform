<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211212005053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partner (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_312B3E16E7927C74 ON partner (email)');
        $this->addSql('DROP INDEX UNIQ_C7440455E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, name, first_name, email, roles, password, created FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, partner_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, first_name VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(180) NOT NULL COLLATE BINARY, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , password VARCHAR(255) NOT NULL COLLATE BINARY, created DATETIME NOT NULL, CONSTRAINT FK_C74404559393F8FE FOREIGN KEY (partner_id) REFERENCES partner (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO client (id, name, first_name, email, roles, password, created) SELECT id, name, first_name, email, roles, password, created FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
        $this->addSql('CREATE INDEX IDX_C74404559393F8FE ON client (partner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP INDEX UNIQ_C7440455E7927C74');
        $this->addSql('DROP INDEX IDX_C74404559393F8FE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, name, first_name, email, roles, password, created FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, created DATETIME NOT NULL)');
        $this->addSql('INSERT INTO client (id, name, first_name, email, roles, password, created) SELECT id, name, first_name, email, roles, password, created FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
    }
}
