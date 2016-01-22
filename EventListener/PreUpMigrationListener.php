<?php

namespace RDV\Bundle\MigrationBundle\EventListener;

use RDV\Bundle\MigrationBundle\Event\PreMigrationEvent;
use RDV\Bundle\MigrationBundle\Migration\CreateMigrationTableMigration;
use RDV\Bundle\MigrationBundle\Migration\Tables;

class PreUpMigrationListener
{
    /**
     * @param PreMigrationEvent $event
     */
    public function onPreUp(PreMigrationEvent $event)
    {
        if ($event->isTableExist(Tables::MIGRATION_TABLE)) {
            $data = $event->getData(
                sprintf(
                    'select * from %s where id in (select max(id) from %s group by bundle)',
                    Tables::MIGRATION_TABLE,
                    Tables::MIGRATION_TABLE
                )
            );
            foreach ($data as $val) {
                $event->setLoadedVersion($val['bundle'], $val['version']);
            }
        } else {
            $event->addMigration(new CreateMigrationTableMigration());
        }
    }
}
