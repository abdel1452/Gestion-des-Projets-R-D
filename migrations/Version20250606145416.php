<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250606145416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de la table project';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE project (
                id SERIAL NOT NULL,
                name VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                image_filename VARCHAR(255) DEFAULT NULL,
                prod_url VARCHAR(255) null,
                preprod_url VARCHAR(255) null,
                PRIMARY KEY(id)
            )
        SQL);
        
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE project');
    }
}
