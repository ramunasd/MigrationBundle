<?php

namespace RDV\Bundle\MigrationBundle\Tests\Functional\DependencyInjection;

use RDV\Bundle\MigrationBundle\Migration\Loader\MigrationsLoader;
use RDV\Bundle\MigrationBundle\Tests\Functional\Fixture\Kernel;
use RDV\Bundle\MigrationBundle\Tests\Unit\Fixture\TestPackage\Test1Bundle\TestPackageTest1Bundle;
use RDV\Bundle\MigrationBundle\Tests\Unit\Fixture\TestPackage\Test2Bundle\TestPackageTest2Bundle;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        array_map('unlink', glob(__DIR__ . '/../Fixture/cache/test/*.[php|xml]*'));
    }

    public function testMigrationsIsLoadedOnlyFromCertainPath()
    {
        $kernel = new Kernel('test', true);
        $kernel->setRegistrableBundles(array(
            new TestPackageTest1Bundle(),
            new TestPackageTest2Bundle(),
        ));

        $kernel->boot();

        $container = $kernel->getContainer();
        $config = $container->getParameter('rdv_migration');
        $this->assertEquals(MigrationsLoader::DEFAULT_MIGRATIONS_PATH, $config['migration_path']);

        /** @var \RDV\Bundle\MigrationBundle\Migration\Loader\MigrationsLoader $loader */
        $loader = $container->get('rdv_migration.migrations.loader');
        $migrations = $loader->getMigrations();
        $this->assertCount(8, $migrations);

        $kernel->shutdown();
        $this->tearDown();
        $kernel->setConfigCallback(function ($container) {
            $container->setParameter('rdv_migration', array(
                'migration_path' => 'NonExistingPath',
            ));
        });
        $kernel->boot();

        $loader->setMigrationPath('NonExistingPath');
        $migrations = $loader->getMigrations();
        $this->assertCount(2, $migrations); // 2 migrations comes from this bundle itself, @todo
    }
}
