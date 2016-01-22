<?php

namespace RDV\Bundle\MigrationBundle\Migration\Extension;

interface DataStorageExtensionAwareInterface
{
    /**
     * @param DataStorageExtension $dataStorageExtension
     */
    public function setDataStorageExtension(DataStorageExtension $dataStorageExtension);
}
