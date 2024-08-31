<?php

declare(strict_types=1);

namespace App\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240831121322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adventure (adventure_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', budget_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', serial_number INT NOT NULL, order_number VARCHAR(255) DEFAULT NULL, adventure_name VARCHAR(255) NOT NULL, date DATETIME NOT NULL, department VARCHAR(255) NOT NULL, participants_count INT NOT NULL, provider_name VARCHAR(255) NOT NULL, coordinator_name VARCHAR(255) NOT NULL, estimated_cost DOUBLE PRECISION NOT NULL, actual_cost DOUBLE PRECISION DEFAULT NULL, approved TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_9E858E0FD948EE2 (serial_number), INDEX IDX_9E858E0F36ABA6B8 (budget_id), PRIMARY KEY(adventure_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budget (budget_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', year INT NOT NULL, semester INT NOT NULL, part INT NOT NULL, starting_capital INT DEFAULT NULL, estimated_cost INT NOT NULL, actual_cost INT NOT NULL, final_balance INT NOT NULL, PRIMARY KEY(budget_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adventure ADD CONSTRAINT FK_9E858E0F36ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (budget_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adventure DROP FOREIGN KEY FK_9E858E0F36ABA6B8');
        $this->addSql('DROP TABLE adventure');
        $this->addSql('DROP TABLE budget');
    }
}
