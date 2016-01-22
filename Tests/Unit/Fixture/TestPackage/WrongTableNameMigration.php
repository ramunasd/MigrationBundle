<?php

namespace RDV\Bundle\MigrationBundle\Tests\Unit\Fixture\TestPackage;

use Doctrine\DBAL\Schema\Schema;
use RDV\Bundle\MigrationBundle\Migration\Migration;
use RDV\Bundle\MigrationBundle\Migration\QueryBag;

class WrongTableNameMigration implements Migration
{
    /**
     * @inheritdoc
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->createTable('extra_long_table_name_bigger_than_30_chars');
        $table->addColumn('id', 'integer');
    }
}
