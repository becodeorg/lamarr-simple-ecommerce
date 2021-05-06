<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506095647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shopping_line ADD shoppingcart_id INT NOT NULL');
        $this->addSql('ALTER TABLE shopping_line ADD CONSTRAINT FK_A81DE8B7685930AE FOREIGN KEY (shoppingcart_id) REFERENCES shoppingcart (id)');
        $this->addSql('CREATE INDEX IDX_A81DE8B7685930AE ON shopping_line (shoppingcart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shopping_line DROP FOREIGN KEY FK_A81DE8B7685930AE');
        $this->addSql('DROP INDEX IDX_A81DE8B7685930AE ON shopping_line');
        $this->addSql('ALTER TABLE shopping_line DROP shoppingcart_id');
    }
}
