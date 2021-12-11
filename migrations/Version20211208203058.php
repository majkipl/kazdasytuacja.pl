<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211208203058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flashlight (id INT AUTO_INCREMENT NOT NULL, gender_id INT NOT NULL, shop_id INT NOT NULL, category_id INT NOT NULL, firstname VARCHAR(128) NOT NULL, lastname VARCHAR(128) NOT NULL, email VARCHAR(255) NOT NULL, street VARCHAR(128) NOT NULL, city VARCHAR(128) NOT NULL, from_where VARCHAR(255) NOT NULL, receipt VARCHAR(255) NOT NULL, product VARCHAR(255) NOT NULL, birth DATE NOT NULL, legal_a TINYINT(1) NOT NULL, legal_b TINYINT(1) NOT NULL, legal_c TINYINT(1) NOT NULL, INDEX IDX_D7A22BF708A0E0 (gender_id), INDEX IDX_D7A22BF4D16C4DD (shop_id), INDEX IDX_D7A22BF12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gender (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flashlight ADD CONSTRAINT FK_D7A22BF708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id)');
        $this->addSql('ALTER TABLE flashlight ADD CONSTRAINT FK_D7A22BF4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE flashlight ADD CONSTRAINT FK_D7A22BF12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EMAIL ON flashlight (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_EMAIL ON flashlight');
        $this->addSql('ALTER TABLE flashlight DROP FOREIGN KEY FK_D7A22BF708A0E0');
        $this->addSql('ALTER TABLE flashlight DROP FOREIGN KEY FK_D7A22BF4D16C4DD');
        $this->addSql('ALTER TABLE flashlight DROP FOREIGN KEY FK_D7A22BF12469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE flashlight');
        $this->addSql('DROP TABLE gender');
        $this->addSql('DROP TABLE shop');

    }
}
