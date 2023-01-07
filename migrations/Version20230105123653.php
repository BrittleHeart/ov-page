<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230105123653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rss__result ADD rss_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rss__result ADD CONSTRAINT FK_E2AA83D1FF875BE4 FOREIGN KEY (rss_group_id) REFERENCES "rss_group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E2AA83D1FF875BE4 ON rss__result (rss_group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "rss__result" DROP CONSTRAINT FK_E2AA83D1FF875BE4');
        $this->addSql('DROP INDEX IDX_E2AA83D1FF875BE4');
        $this->addSql('ALTER TABLE "rss__result" DROP rss_group_id');
    }
}
