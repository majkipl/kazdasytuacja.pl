<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211210133456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, gender_id INT NOT NULL, shop_id INT NOT NULL, category_id INT NOT NULL, firstname VARCHAR(128) NOT NULL, lastname VARCHAR(128) NOT NULL, email VARCHAR(255) NOT NULL, street VARCHAR(128) NOT NULL, city VARCHAR(128) NOT NULL, from_where VARCHAR(255) NOT NULL, receipt VARCHAR(255) NOT NULL, product VARCHAR(255) NOT NULL, birth DATE NOT NULL, legal_a TINYINT(1) NOT NULL, legal_b TINYINT(1) NOT NULL, legal_c TINYINT(1) NOT NULL, code VARCHAR(6) NOT NULL, try LONGTEXT NOT NULL, INDEX IDX_7656F53B708A0E0 (gender_id), INDEX IDX_7656F53B4D16C4DD (shop_id), INDEX IDX_7656F53B12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EMAIL ON trip (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_EMAIL ON trip');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B708A0E0');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B4D16C4DD');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B12469DE2');
        $this->addSql('DROP TABLE trip');
    }
}
