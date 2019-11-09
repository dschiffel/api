<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191109152323 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE deploy_attribute DROP FOREIGN KEY FK_859118424E0AA1CD');
        $this->addSql('DROP INDEX IDX_859118424E0AA1CD ON deploy_attribute');
        $this->addSql('ALTER TABLE deploy_attribute CHANGE rel_id deploy_id INT NOT NULL');
        $this->addSql('ALTER TABLE deploy_attribute ADD CONSTRAINT FK_859118427886667B FOREIGN KEY (deploy_id) REFERENCES deploy (id)');
        $this->addSql('CREATE INDEX IDX_859118427886667B ON deploy_attribute (deploy_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE deploy_attribute DROP FOREIGN KEY FK_859118427886667B');
        $this->addSql('DROP INDEX IDX_859118427886667B ON deploy_attribute');
        $this->addSql('ALTER TABLE deploy_attribute CHANGE deploy_id rel_id INT NOT NULL');
        $this->addSql('ALTER TABLE deploy_attribute ADD CONSTRAINT FK_859118424E0AA1CD FOREIGN KEY (rel_id) REFERENCES deploy (id)');
        $this->addSql('CREATE INDEX IDX_859118424E0AA1CD ON deploy_attribute (rel_id)');
    }
}
