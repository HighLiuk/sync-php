<?php

namespace HighLiuk\Sync\Exceptions;

use Exception;
use HighLiuk\Sync\Interfaces\SyncModel;

/**
 * Exception thrown when a model is not found.
 *
 * @template ID of string|int
 */
class ModelNotFoundException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param SyncModel<ID> $model
     */
    public function __construct(SyncModel $model)
    {
        parent::__construct("Model with ID {$model->getId()} not found.");
    }
}
