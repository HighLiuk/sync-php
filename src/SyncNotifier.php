<?php

namespace HighLiuk\Sync;

use HighLiuk\Sync\Interfaces\SyncNotifier as ISyncNotifier;
use Throwable;

class SyncNotifier implements ISyncNotifier
{
    public function beforeCreate(array $models): void
    {
    }

    public function beforeUpdate(array $models): void
    {
    }

    public function beforeDelete(array $ids): void
    {
    }

    public function afterCreate(array $models): void
    {
    }

    public function afterUpdate(array $models): void
    {
    }

    public function afterDelete(array $ids): void
    {
    }

    public function onCreateError(array $models, Throwable $e): void
    {
    }

    public function onUpdateError(array $models, Throwable $e): void
    {
    }

    public function onDeleteError(array $ids, Throwable $e): void
    {
    }
}
