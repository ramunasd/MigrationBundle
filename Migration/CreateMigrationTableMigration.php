<?php

namespace RDV\Bundle\MigrationBundle\Migration;

use Doctrine\DBAL\Schema\Schema;

class CreateMigrationTableMigration implements Migration
{
    /**
     * @inheritdoc
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->createTable(Tables::MIGRATION_TABLE);
        $table->addColumn('id', 'integer', ['notnull' => true, 'autoincrement' => true]);
        $table->addColumn('bundle', 'string', ['notnull' => true, 'length' => 250]);
        $table->addColumn('version', 'string', ['notnull' => true, 'length' => 250]);
        $table->addColumn('loaded_at', 'datetime', ['notnull' => true]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['bundle'], 'idx_rdv_migrations', []);

        $table = $schema->createTable(Tables::MIGRATION_DATA_TABLE);
        $table->addColumn('id', 'integer', ['notnull' => true, 'autoincrement' => true]);
        $table->addColumn('class_name', 'string', ['default' => null, 'notnull' => true, 'length' => 255]);
        $table->addColumn('loaded_at', 'datetime', ['notnull' => true]);
        $table->addColumn('version', 'string', ['notnull' => false, 'length' => 255]);
        $table->setPrimaryKey(['id']);
    }
}
