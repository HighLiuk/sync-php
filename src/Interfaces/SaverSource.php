<?php

namespace HighLiuk\Sync\Interfaces;

interface SaverSource
{
    /**
     * Save the items to the source.
     *
     * @param  array<string,array<string,mixed>>  $items
     */
    public function save(array $items): void;
}
