<?php

namespace RDV\Bundle\MigrationBundle\Tests\Unit\Migration\Fixtures\Extension;

interface TestExtensionAwareInterface
{
    public function setTestExtension(TestExtension $testExtension);
}
