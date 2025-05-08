<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250508170014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE faker_node ADD instructions VARCHAR(80) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE node DROP FOREIGN KEY FK_857FE8455DA0FB8
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_857FE8455DA0FB8 ON node
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE node DROP template_id, DROP instructions
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE faker_node DROP instructions
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE node ADD template_id INT NOT NULL, ADD instructions VARCHAR(80) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE node ADD CONSTRAINT FK_857FE8455DA0FB8 FOREIGN KEY (template_id) REFERENCES template (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_857FE8455DA0FB8 ON node (template_id)
        SQL);
    }
}
