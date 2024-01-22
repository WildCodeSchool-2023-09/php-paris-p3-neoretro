<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122142949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_played (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, score_player_one INT NOT NULL, score_player_two INT DEFAULT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', duration TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', INDEX IDX_11F862FCE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_played_user (game_played_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_245325FE3E323C9E (game_played_id), INDEX IDX_245325FEA76ED395 (user_id), PRIMARY KEY(game_played_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_played ADD CONSTRAINT FK_11F862FCE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_played_user ADD CONSTRAINT FK_245325FE3E323C9E FOREIGN KEY (game_played_id) REFERENCES game_played (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_played_user ADD CONSTRAINT FK_245325FEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_played DROP FOREIGN KEY FK_11F862FCE48FD905');
        $this->addSql('ALTER TABLE game_played_user DROP FOREIGN KEY FK_245325FE3E323C9E');
        $this->addSql('ALTER TABLE game_played_user DROP FOREIGN KEY FK_245325FEA76ED395');
        $this->addSql('DROP TABLE game_played');
        $this->addSql('DROP TABLE game_played_user');
    }
}
