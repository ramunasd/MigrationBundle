<?php

namespace RDV\Bundle\MigrationBundle\Tests\Unit\Migration;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use RDV\Bundle\MigrationBundle\Migration\MigrationExtensionManager;
use RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\Extension\InvalidAwareInterfaceExtension;
use RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\Extension\TestExtension;
use RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\Extension\AnotherTestExtension;
use RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\Extension\TestExtensionDepended;
use RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\MigrationWithTestExtension;
use RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\Extension\NoAwareInterfaceExtension;
use RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\Extension\AnotherNoAwareInterfaceExtension;
use RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\MigrationWithTestExtensionDepended;
use RDV\Bundle\MigrationBundle\Tools\DbIdentifierNameGenerator;

class MigrationExtensionManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testValidExtension()
    {
        $migration = new MigrationWithTestExtension();
        $extension = new TestExtension();
        $platform = new MySqlPlatform();
        $nameGenerator = new DbIdentifierNameGenerator();

        $manager = new MigrationExtensionManager();
        $manager->addExtension('test', $extension);
        $manager->applyExtensions($migration);

        $this->assertSame($extension, $migration->getTestExtension());
        $this->assertNull($extension->getDatabasePlatform());
        $this->assertNull($extension->getNameGenerator());

        $manager->setDatabasePlatform($platform);
        $this->assertSame($platform, $extension->getDatabasePlatform());

        $manager->setNameGenerator($nameGenerator);
        $this->assertSame($nameGenerator, $extension->getNameGenerator());

        $this->assertNull($migration->getDatabasePlatform());
        $this->assertNull($migration->getNameGenerator());
        $manager->applyExtensions($migration);
        $this->assertSame($platform, $migration->getDatabasePlatform());
        $this->assertSame($nameGenerator, $migration->getNameGenerator());
    }

    public function testAnotherValidExtension()
    {
        $migration = new MigrationWithTestExtension();
        $extension = new AnotherTestExtension();
        $platform = new MySqlPlatform();
        $nameGenerator = new DbIdentifierNameGenerator();

        $manager = new MigrationExtensionManager();
        $manager->addExtension('test', $extension);
        $manager->applyExtensions($migration);

        $this->assertSame($extension, $migration->getTestExtension());
        $this->assertNull($extension->getDatabasePlatform());
        $this->assertNull($extension->getNameGenerator());

        $manager->setDatabasePlatform($platform);
        $this->assertSame($platform, $extension->getDatabasePlatform());

        $manager->setNameGenerator($nameGenerator);
        $this->assertSame($nameGenerator, $extension->getNameGenerator());

        $this->assertNull($migration->getDatabasePlatform());
        $this->assertNull($migration->getNameGenerator());
        $manager->applyExtensions($migration);
        $this->assertSame($platform, $migration->getDatabasePlatform());
        $this->assertSame($nameGenerator, $migration->getNameGenerator());
    }

    public function testValidExtensionWithDependencies()
    {
        $migration = new MigrationWithTestExtension();
        $extension = new TestExtension();
        $platform = new MySqlPlatform();
        $nameGenerator = new DbIdentifierNameGenerator();

        $manager = new MigrationExtensionManager();
        $manager->setDatabasePlatform($platform);
        $manager->setNameGenerator($nameGenerator);
        $manager->addExtension('test', $extension);
        $manager->applyExtensions($migration);

        $this->assertSame($extension, $migration->getTestExtension());
        $this->assertSame($platform, $extension->getDatabasePlatform());
        $this->assertSame($nameGenerator, $extension->getNameGenerator());
        $this->assertSame($platform, $migration->getDatabasePlatform());
        $this->assertSame($nameGenerator, $migration->getNameGenerator());
    }

    public function testAnotherValidExtensionWithDependencies()
    {
        $migration = new MigrationWithTestExtension();
        $extension = new AnotherTestExtension();
        $platform = new MySqlPlatform();
        $nameGenerator = new DbIdentifierNameGenerator();

        $manager = new MigrationExtensionManager();
        $manager->setDatabasePlatform($platform);
        $manager->setNameGenerator($nameGenerator);
        $manager->addExtension('test', $extension);
        $manager->applyExtensions($migration);

        $this->assertSame($extension, $migration->getTestExtension());
        $this->assertSame($platform, $extension->getDatabasePlatform());
        $this->assertSame($nameGenerator, $extension->getNameGenerator());
        $this->assertSame($platform, $migration->getDatabasePlatform());
        $this->assertSame($nameGenerator, $migration->getNameGenerator());
    }

    public function testExtensionDependedToOtherExtension()
    {
        $migration = new MigrationWithTestExtensionDepended();
        $otherExtension = new TestExtension();
        $extension = new TestExtensionDepended();

        $manager = new MigrationExtensionManager();
        $manager->addExtension('test', $extension);
        $manager->addExtension('other', $otherExtension);
        $manager->applyExtensions($migration);

        $this->assertSame($extension, $migration->getTestExtensionDepended());
        $this->assertSame($otherExtension, $migration->getTestExtensionDepended()->getTestExtension());
    }

    public function testExtensionWithNoAwareInterface()
    {
        $dir = 'RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\Extension';
        $this->setExpectedException(
            '\RuntimeException',
            sprintf(
                'The extension aware interface for "%s\NoAwareInterfaceExtension" was not found. '
                . 'Make sure that "%s\NoAwareInterfaceExtensionAwareInterface" interface is declared.',
                $dir,
                $dir
            )
        );

        $manager = new MigrationExtensionManager();
        $manager->addExtension('test', new NoAwareInterfaceExtension());
    }

    public function testAnotherExtensionWithNoAwareInterface()
    {
        $dir = 'RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\Extension';
        $this->setExpectedException(
            '\RuntimeException',
            sprintf(
                'The extension aware interface for neither "%s\AnotherNoAwareInterfaceExtension"'
                . ' not one of its parent classes was not found.',
                $dir
            )
        );

        $manager = new MigrationExtensionManager();
        $manager->addExtension('test', new AnotherNoAwareInterfaceExtension());
    }

    public function testExtensionWithInvalidAwareInterface()
    {
        $dir = 'RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\Extension';
        $this->setExpectedException(
            '\RuntimeException',
            sprintf(
                'The method "%s\InvalidAwareInterfaceExtensionAwareInterface::setInvalidAwareInterfaceExtension"'
                . ' was not found.',
                $dir
            )
        );

        $manager = new MigrationExtensionManager();
        $manager->addExtension('test', new InvalidAwareInterfaceExtension());
    }
}
