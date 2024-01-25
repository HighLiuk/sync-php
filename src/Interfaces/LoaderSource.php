<?php

namespace HighLiuk\Sync\Interfaces;

interface LoaderSource
{
    /**
     * Load the items from the source.
     *
     * @return array<string,mixed>[]
     */
    public function load(): array;
}
