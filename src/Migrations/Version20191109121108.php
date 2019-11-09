<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191109121108 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, environment_id INT NOT NULL, attribute_id INT NOT NULL, value VARCHAR(1023) DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A393D2FB903E3A94 (environment_id), INDEX IDX_A393D2FBB6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id)');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FBB6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('DROP TABLE value');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE value (id INT AUTO_INCREMENT NOT NULL, environment_id INT NOT NULL, attribute_id INT NOT NULL, value VARCHAR(1023) DEFAULT NULL COLLATE utf8mb4_unicode_ci, updated_at DATETIME NOT NULL, INDEX IDX_1D775834B6E62EFA (attribute_id), INDEX IDX_1D775834903E3A94 (environment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE value ADD CONSTRAINT FK_1D775834903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id)');
        $this->addSql('ALTER TABLE value ADD CONSTRAINT FK_1D775834B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('DROP TABLE state');
    }
}