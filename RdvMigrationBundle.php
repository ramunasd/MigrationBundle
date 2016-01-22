<?php

namespace RDV\Bundle\MigrationBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use RDV\Bundle\MigrationBundle\DependencyInjection\Compiler\MigrationExtensionPass;

class RdvMigrationBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MigrationExtensionPass());
    }
}
