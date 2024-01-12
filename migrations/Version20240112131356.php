<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112131356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE token token INT DEFAULT NULL, CHANGE phonenumber phonenumber VARCHAR(10) DEFAULT NULL, CHANGE adress adress VARCHAR(100) DEFAULT NULL, CHANGE city city VARCHAR(20) DEFAULT NULL, CHANGE zipcode zipcode VARCHAR(5) DEFAULT NULL, CHANGE experience experience INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE token token INT NOT NULL, CHANGE phonenumber phonenumber VARCHAR(10) NOT NULL, CHANGE adress adress VARCHAR(100) NOT NULL, CHANGE city city VARCHAR(20) NOT NULL, CHANGE zipcode zipcode VARCHAR(5) NOT NULL, CHANGE experience experience INT NOT NULL');
    }
}
