<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109095204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_game (category_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_A8B04BCB12469DE2 (category_id), INDEX IDX_A8B04BCBE48FD905 (game_id), PRIMARY KEY(category_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, poster VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_virtual TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_16DB4F89E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prize (id INT AUTO_INCREMENT NOT NULL, prize_label VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(255) NOT NULL, value INT NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prize_user (prize_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_287FDEEBBE43214 (prize_id), INDEX IDX_287FDEEA76ED395 (user_id), PRIMARY KEY(prize_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, token INT NOT NULL, phonenumber VARCHAR(10) NOT NULL, adress VARCHAR(100) NOT NULL, city VARCHAR(20) NOT NULL, zipcode VARCHAR(5) NOT NULL, email VARCHAR(30) NOT NULL, experience INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_game ADD CONSTRAINT FK_A8B04BCB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_game ADD CONSTRAINT FK_A8B04BCBE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE prize_user ADD CONSTRAINT FK_287FDEEBBE43214 FOREIGN KEY (prize_id) REFERENCES prize (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prize_user ADD CONSTRAINT FK_287FDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_game DROP FOREIGN KEY FK_A8B04BCB12469DE2');
        $this->addSql('ALTER TABLE category_game DROP FOREIGN KEY FK_A8B04BCBE48FD905');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89E48FD905');
        $this->addSql('ALTER TABLE prize_user DROP FOREIGN KEY FK_287FDEEBBE43214');
        $this->addSql('ALTER TABLE prize_user DROP FOREIGN KEY FK_287FDEEA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_game');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE prize');
        $this->addSql('DROP TABLE prize_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
