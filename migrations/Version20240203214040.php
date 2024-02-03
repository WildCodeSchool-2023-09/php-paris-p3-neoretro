<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240203214040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, poster VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, description LONGTEXT NOT NULL, is_virtual TINYINT(1) NOT NULL, is_visible TINYINT(1) DEFAULT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_category (game_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_AD08E6E7E48FD905 (game_id), INDEX IDX_AD08E6E712469DE2 (category_id), PRIMARY KEY(game_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_played (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, player_id INT NOT NULL, score INT NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', duration INT NOT NULL, uuid VARCHAR(255) NOT NULL, INDEX IDX_11F862FCE48FD905 (game_id), INDEX IDX_11F862FC99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_16DB4F89E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prize (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, poster VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL, value INT NOT NULL, quantity INT NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, token INT NOT NULL, phonenumber VARCHAR(16) DEFAULT NULL, adress VARCHAR(100) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, zipcode VARCHAR(5) DEFAULT NULL, email VARCHAR(40) NOT NULL, experience INT NOT NULL, level INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_category ADD CONSTRAINT FK_AD08E6E7E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_category ADD CONSTRAINT FK_AD08E6E712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_played ADD CONSTRAINT FK_11F862FCE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_played ADD CONSTRAINT FK_11F862FC99E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_category DROP FOREIGN KEY FK_AD08E6E7E48FD905');
        $this->addSql('ALTER TABLE game_category DROP FOREIGN KEY FK_AD08E6E712469DE2');
        $this->addSql('ALTER TABLE game_played DROP FOREIGN KEY FK_11F862FCE48FD905');
        $this->addSql('ALTER TABLE game_played DROP FOREIGN KEY FK_11F862FC99E6F5DF');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89E48FD905');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_category');
        $this->addSql('DROP TABLE game_played');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE prize');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
