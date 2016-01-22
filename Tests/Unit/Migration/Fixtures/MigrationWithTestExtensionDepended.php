<?php

namespace RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures;

use Doctrine\DBAL\Schema\Schema;
use RDV\Bundle\MigrationBundle\Migration\Migration;
use RDV\Bundle\MigrationBundle\Migration\QueryBag;
use RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\Extension\TestExtensionDepended;
use RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\Extension\TestExtensionDependedAwareInterface;

class MigrationWithTestExtensionDepended implements
    Migration,
    TestExtensionDependedAwareInterface
{
    protected $testExtensionDepended;

    public function setTestExtensionDepended(
        TestExtensionDepended $testExtensionDepended
    ) {
        $this->testExtensionDepended = $testExtensionDepended;
    }

    public function getTestExtensionDepended()
    {
        return $this->testExtensionDepended;
    }

    public function up(Schema $schema, QueryBag $queries)
    {
    }
}
