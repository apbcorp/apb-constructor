<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180201163522 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE `user` (
              id INT AUTO_INCREMENT NOT NULL,
              username VARCHAR(255) NOT NULL COLLATE utf8_general_ci,
              password VARCHAR(255) NOT NULL COLLATE utf8_general_ci,
              salt VARCHAR(255) NOT NULL COLLATE utf8_general_ci,
              email VARCHAR(255) NOT NULL COLLATE utf8_general_ci,
              is_developer int(1) unsigned NOT NULL,
              is_active int(1) unsigned NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `user`');
    }
}
