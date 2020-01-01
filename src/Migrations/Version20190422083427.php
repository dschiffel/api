<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190422083427 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create attribute table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE attribute (id INT AUTO_INCREMENT NOT NULL, application_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_FA7AEFFB3E030ACD (application_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFB3E030ACD FOREIGN KEY (application_id) REFERENCES application (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE attribute');
    }
}
