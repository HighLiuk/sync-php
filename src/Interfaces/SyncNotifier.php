<?php

namespace HighLiuk\Sync\Interfaces;

use HighLiuk\Sync\SyncModel;
use Throwable;

interface SyncNotifier
{
    /**
     * Do something before creating the given models in the source.
     *
     * @param  SyncModel[]  $models
     */
    public function beforeCreate(array $models): void;

    /**
     * Do something before updating the given models in the source.
     *
     * @param  SyncModel[]  $models
     */
    public function beforeUpdate(array $models): void;

    /**
     * Do something before deleting the models with the given ids from the source.
     *
     * @param  string[]  $ids
     */
    public function beforeDelete(array $ids): void;

    /**
     * Do something after creating the given models in the source.
     *
     * @param  SyncModel[]  $models
     */
    public function afterCreate(array $models): void;

    /**
     * Do something after updating the given models in the source.
     *
     * @param  SyncModel[]  $models
     */
    public function afterUpdate(array $models): void;

    /**
     * Do something after deleting the models with the given ids from the source.
     *
     * @param  string[]  $ids
     */
    public function afterDelete(array $ids): void;

    /**
     * Do something when an error occurs while creating the given models in the source.
     *
     * @param  SyncModel[]  $models
     */
    public function onCreateError(array $models, Throwable $e): void;

    /**
     * Do something when an error occurs while updating the given models in the source.
     *
     * @param  SyncModel[]  $models
     */
    public function onUpdateError(array $models, Throwable $e): void;

    /**
     * Do something when an error occurs while deleting the models with the given ids
     * from the source.
     *
     * @param  string[]  $ids
     */
    public function onDeleteError(array $ids, Throwable $e): void;
}
