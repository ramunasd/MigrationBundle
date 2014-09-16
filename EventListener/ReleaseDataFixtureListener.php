<?php

namespace Oro\Bundle\MigrationBundle\EventListener;

use Symfony\Component\Yaml\Yaml;

use Oro\Bundle\MigrationBundle\Event\PreMigrationEvent;
use Oro\Bundle\MigrationBundle\Event\PostMigrationEvent;
use Oro\Bundle\MigrationBundle\Migration\CreateMigrationTableMigration;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\ReleaseDataFixtureMigration;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * TODO: This listener is a temporary solution for migration of data fixtures.
 * TODO: It should be removed in scope of https://magecore.atlassian.net/browse/BAP-3605
 */
class ReleaseDataFixtureListener implements ContainerAwareInterface
{
    /**
     * @var Migration
     */
    protected $dataMigration;

    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param PreMigrationEvent $event
     */
    public function onPreUp(PreMigrationEvent $event)
    {
        // if need to move data from old table oro_installer_bundle_version to new table oro_migrations
        if ($event->isTableExist('oro_installer_bundle_version')
            && !$event->isTableExist(CreateMigrationTableMigration::MIGRATION_TABLE)
        ) {
            $fixturesData = $event->getData('SELECT * FROM oro_installer_bundle_version');
            $mappingData = $this->getMappingData();

            $this->dataMigration = new ReleaseDataFixtureMigration($fixturesData, $mappingData);
        }
    }

    /**
     * @param PostMigrationEvent $event
     */
    public function onPostUp(PostMigrationEvent $event)
    {
        if ($this->dataMigration) {
            $event->addMigration($this->dataMigration);
        }
    }

    /**
     * @return array
     */
    protected function getMappingData()
    {
        $filePath = $this->container
            ->get('kernel')
            ->locateResource('@OroMigrationBundle/EventListener/data/1.0.0/platform.yml');
        return Yaml::parse(realpath($filePath));
    }
}
