<?php

namespace RDV\Bundle\MigrationBundle\Fixture;

/**
 * @deprecated interface VersionedFixtureInterface holds both methods - getVersion() and setLoadedVersion()
 */
interface LoadedFixtureVersionAwareInterface
{
    /**
     * Set current loaded fixture version
     *
     * @param $version
     */
    public function setLoadedVersion($version = null);
}
