<?php

namespace RDV\Bundle\MigrationBundle\Fixture;

interface LoadedFixtureVersionAwareInterface
{
    /**
     * Set current loaded fixture version
     *
     * @param $version
     */
    public function setLoadedVersion($version = null);
}
