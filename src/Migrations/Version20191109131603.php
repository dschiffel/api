<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191109131603 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE attribute DROP FOREIGN KEY FK_FA7AEFFB3E030ACD');
        $this->addSql('ALTER TABLE environment DROP FOREIGN KEY FK_4626DE223E030ACD');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP INDEX IDX_FA7AEFFB3E030ACD ON attribute');
        $this->addSql('ALTER TABLE attribute DROP application_id');
        $this->addSql('DROP INDEX IDX_4626DE223E030ACD ON environment');
        $this->addSql('ALTER TABLE environment DROP application_id');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE attribute ADD application_id INT NOT NULL');
        $this->addSql('ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFB3E030ACD FOREIGN KEY (application_id) REFERENCES application (id)');
        $this->addSql('CREATE INDEX IDX_FA7AEFFB3E030ACD ON attribute (application_id)');
        $this->addSql('ALTER TABLE environment ADD application_id INT NOT NULL');
        $this->addSql('ALTER TABLE environment ADD CONSTRAINT FK_4626DE223E030ACD FOREIGN KEY (application_id) REFERENCES application (id)');
        $this->addSql('CREATE INDEX IDX_4626DE223E030ACD ON environment (application_id)');
    }
}
