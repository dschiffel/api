<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191109140343 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE release_attribute DROP FOREIGN KEY FK_C094BEEE4E0AA1CD');
        $this->addSql('CREATE TABLE deploy (id INT AUTO_INCREMENT NOT NULL, environment_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_923B38FA903E3A94 (environment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deploy_attribute (id INT AUTO_INCREMENT NOT NULL, rel_id INT NOT NULL, attribute_id INT NOT NULL, value VARCHAR(255) DEFAULT NULL, INDEX IDX_859118424E0AA1CD (rel_id), INDEX IDX_85911842B6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE deploy ADD CONSTRAINT FK_923B38FA903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id)');
        $this->addSql('ALTER TABLE deploy_attribute ADD CONSTRAINT FK_859118424E0AA1CD FOREIGN KEY (rel_id) REFERENCES deploy (id)');
        $this->addSql('ALTER TABLE deploy_attribute ADD CONSTRAINT FK_85911842B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('DROP TABLE `release`');
        $this->addSql('DROP TABLE release_attribute');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE deploy_attribute DROP FOREIGN KEY FK_859118424E0AA1CD');
        $this->addSql('CREATE TABLE `release` (id INT AUTO_INCREMENT NOT NULL, environment_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9E47031D903E3A94 (environment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE release_attribute (id INT AUTO_INCREMENT NOT NULL, rel_id INT NOT NULL, attribute_id INT NOT NULL, value VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_C094BEEEB6E62EFA (attribute_id), INDEX IDX_C094BEEE4E0AA1CD (rel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `release` ADD CONSTRAINT FK_9E47031D903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id)');
        $this->addSql('ALTER TABLE release_attribute ADD CONSTRAINT FK_C094BEEE4E0AA1CD FOREIGN KEY (rel_id) REFERENCES `release` (id)');
        $this->addSql('ALTER TABLE release_attribute ADD CONSTRAINT FK_C094BEEEB6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('DROP TABLE deploy');
        $this->addSql('DROP TABLE deploy_attribute');
    }
}
