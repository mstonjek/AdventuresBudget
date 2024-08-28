<?php

declare(strict_types=1);

namespace App\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240828155017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget (budget_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', year INT NOT NULL, semester INT NOT NULL, part INT NOT NULL, starting_capital INT DEFAULT NULL, estimated_cost INT NOT NULL, actual_cost INT NOT NULL, final_balance INT NOT NULL, PRIMARY KEY(budget_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adventure ADD budget_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', ADD approved TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE adventure ADD CONSTRAINT FK_9E858E0F36ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (budget_id)');
        $this->addSql('CREATE INDEX IDX_9E858E0F36ABA6B8 ON adventure (budget_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adventure DROP FOREIGN KEY FK_9E858E0F36ABA6B8');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP INDEX IDX_9E858E0F36ABA6B8 ON adventure');
        $this->addSql('ALTER TABLE adventure DROP budget_id, DROP approved');
    }
}
