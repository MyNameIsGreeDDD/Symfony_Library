<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326180054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE author_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE books_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE author (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE authors_books (author_id INT NOT NULL, books_id INT NOT NULL, PRIMARY KEY(author_id, books_id))');
        $this->addSql('CREATE INDEX IDX_2DFDA3CBF675F31B ON authors_books (author_id)');
        $this->addSql('CREATE INDEX IDX_2DFDA3CB7DD8AC20 ON authors_books (books_id)');
        $this->addSql('CREATE TABLE books (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cover VARCHAR(255) NOT NULL, publication_year INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE authors_books ADD CONSTRAINT FK_2DFDA3CBF675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE authors_books ADD CONSTRAINT FK_2DFDA3CB7DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE authors_books DROP CONSTRAINT FK_2DFDA3CBF675F31B');
        $this->addSql('ALTER TABLE authors_books DROP CONSTRAINT FK_2DFDA3CB7DD8AC20');
        $this->addSql('DROP SEQUENCE author_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE books_id_seq CASCADE');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE authors_books');
        $this->addSql('DROP TABLE books');
    }
}
