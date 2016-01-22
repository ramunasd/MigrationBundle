<?php

namespace RDV\Bundle\MigrationBundle\Tests\Unit\Fixture\TestPackage;

use Doctrine\DBAL\Schema\Schema;
use RDV\Bundle\MigrationBundle\Migration\Migration;
use RDV\Bundle\MigrationBundle\Migration\QueryBag;

class UpdatedColumnIndexMigration implements Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->getTable('index_table2');
        $table->getColumn('key')->setLength(500);
        $table->addIndex(['key'], 'index2');
    }
}
