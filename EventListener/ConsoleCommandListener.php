<?php

namespace RDV\Bundle\MigrationBundle\EventListener;

use Symfony\Component\Console\Event\ConsoleCommandEvent;

use RDV\Bundle\MigrationBundle\Tools\SchemaTrait;

class ConsoleCommandListener
{
    use SchemaTrait;

    /**
     * @param ConsoleCommandEvent $event
     */
    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        if ('doctrine:schema:update' === $event->getCommand()->getName()) {
            $this->overrideSchemaDiff();
        }
    }
}
