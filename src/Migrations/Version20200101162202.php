<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200101162202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add action token';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE action_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, action VARCHAR(63) NOT NULL, token VARCHAR(63) NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_B8F96D87A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_token ADD CONSTRAINT FK_B8F96D87A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE action_token');
    }
}
