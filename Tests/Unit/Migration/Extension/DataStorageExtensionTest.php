<?php

namespace RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Extension;

use RDV\Bundle\MigrationBundle\Migration\Extension\DataStorageExtension;

class DataStorageExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $dataStorage = new DataStorageExtension();
        $dataStorage->set('test', ['test1' => 'test1']);

        $this->assertEquals(
            $dataStorage->get('test'),
            ['test1' => 'test1']
        );

        $this->assertTrue($dataStorage->has('test'));
    }

    public function testHas()
    {
        $dataStorage = new DataStorageExtension();
        $dataStorage->set('test', ['test1' => 'test1']);

        $this->assertTrue($dataStorage->has('test'));
    }
}
