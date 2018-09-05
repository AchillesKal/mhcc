<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180905214747 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer_job ADD service_id INT NOT NULL');
        $this->addSql('ALTER TABLE customer_job ADD CONSTRAINT FK_B42BBE0EED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_B42BBE0EED5CA9E6 ON customer_job (service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer_job DROP FOREIGN KEY FK_B42BBE0EED5CA9E6');
        $this->addSql('DROP INDEX IDX_B42BBE0EED5CA9E6 ON customer_job');
        $this->addSql('ALTER TABLE customer_job DROP service_id');
    }
}
