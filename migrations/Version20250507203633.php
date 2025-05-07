<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250507203633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE faker_node (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE list_node (id INT NOT NULL, list JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE nested_template_node (id INT NOT NULL, nested_template_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_FD7D1C3782BE3C97 (nested_template_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE node (id INT AUTO_INCREMENT NOT NULL, template_id INT NOT NULL, label VARCHAR(20) NOT NULL, instructions VARCHAR(80) DEFAULT NULL, discriminator VARCHAR(255) NOT NULL, INDEX IDX_857FE8455DA0FB8 (template_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE faker_node ADD CONSTRAINT FK_78F69580BF396750 FOREIGN KEY (id) REFERENCES node (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE list_node ADD CONSTRAINT FK_C0B137ACBF396750 FOREIGN KEY (id) REFERENCES node (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nested_template_node ADD CONSTRAINT FK_FD7D1C3782BE3C97 FOREIGN KEY (nested_template_id) REFERENCES template (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nested_template_node ADD CONSTRAINT FK_FD7D1C37BF396750 FOREIGN KEY (id) REFERENCES node (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE node ADD CONSTRAINT FK_857FE8455DA0FB8 FOREIGN KEY (template_id) REFERENCES template (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE faker_node DROP FOREIGN KEY FK_78F69580BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE list_node DROP FOREIGN KEY FK_C0B137ACBF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nested_template_node DROP FOREIGN KEY FK_FD7D1C3782BE3C97
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE nested_template_node DROP FOREIGN KEY FK_FD7D1C37BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE node DROP FOREIGN KEY FK_857FE8455DA0FB8
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE faker_node
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE list_node
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE nested_template_node
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE node
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE template
        SQL);
    }
}
