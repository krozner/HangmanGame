<?php

namespace Hangman\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20000000000000 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        foreach($schema->getTables() as $table) {
            $schema->dropTable($table->getName());
        }
    }
}
