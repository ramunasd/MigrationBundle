<?php

namespace RDV\Bundle\MigrationBundle\Tests\Unit\Fixture\TestPackage;

use Doctrine\DBAL\Schema\Schema;
use RDV\Bundle\MigrationBundle\Migration\Migration;
use RDV\Bundle\MigrationBundle\Migration\QueryBag;

class InvalidIndexMigration implements Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->createTable('index_table');
        $table->addColumn('key', 'string', ['length' => 500]);
        $table->addIndex(['key'], 'index');
    }
}
