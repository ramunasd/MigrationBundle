<?php

namespace RDV\Bundle\MigrationBundle\Tests\Unit\Migration;

use Doctrine\DBAL\Schema\Schema;
use RDV\Bundle\MigrationBundle\Migration\CreateMigrationTableMigration;
use RDV\Bundle\MigrationBundle\Migration\QueryBag;
use RDV\Bundle\MigrationBundle\Migration\Tables;

class CreateMigrationTableMigrationTest extends \PHPUnit_Framework_TestCase
{
    public function testUp()
    {
        $schema          = new Schema();
        $queryBag        = new QueryBag();
        $createMigration = new CreateMigrationTableMigration();
        $createMigration->up($schema, $queryBag);

        $this->assertEmpty($queryBag->getPreQueries());
        $this->assertEmpty($queryBag->getPostQueries());

        $table = $schema->getTable(Tables::MIGRATION_TABLE);
        $this->assertTrue($table->hasColumn('id'));
        $this->assertTrue($table->hasColumn('bundle'));
        $this->assertTrue($table->hasColumn('version'));
        $this->assertTrue($table->hasColumn('loaded_at'));
    }
}
