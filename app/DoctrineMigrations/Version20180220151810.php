<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180220151810 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C1EE637C5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parents (org_id INT NOT NULL, parent_id INT NOT NULL, INDEX IDX_FD501D6AF4837C1B (org_id), INDEX IDX_FD501D6A727ACA70 (parent_id), PRIMARY KEY(org_id, parent_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parents ADD CONSTRAINT FK_FD501D6AF4837C1B FOREIGN KEY (org_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE parents ADD CONSTRAINT FK_FD501D6A727ACA70 FOREIGN KEY (parent_id) REFERENCES organization (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parents DROP FOREIGN KEY FK_FD501D6AF4837C1B');
        $this->addSql('ALTER TABLE parents DROP FOREIGN KEY FK_FD501D6A727ACA70');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE parents');
    }
}
