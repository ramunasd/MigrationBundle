<?php

namespace RDV\Bundle\MigrationBundle\Tests\Unit\Fixture\TestPackage\Test2Bundle\Migrations\Schema\v1_1;

use Doctrine\DBAL\Schema\Schema;
use RDV\Bundle\MigrationBundle\Migration\Migration;
use RDV\Bundle\MigrationBundle\Migration\OrderedMigrationInterface;
use RDV\Bundle\MigrationBundle\Migration\QueryBag;

class Test2BundleMigration12 implements Migration, OrderedMigrationInterface
{
    public function getOrder()
    {
        return 1;
    }

    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->getTable('test1table');
        $table->addColumn('another_column', 'int');
    }
}
