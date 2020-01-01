<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190420100630 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create environment table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE environment (id INT AUTO_INCREMENT NOT NULL, application_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_4626DE223E030ACD (application_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE environment ADD CONSTRAINT FK_4626DE223E030ACD FOREIGN KEY (application_id) REFERENCES application (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE environment');
    }
}
