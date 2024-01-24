<?php

namespace HighLiuk\Sync\Examples\Csv\Src;

use HighLiuk\Sync\Adapters\Csv\CsvReadableSource;

/**
 * @extends CsvReadableSource<User>
 */
class UsersMasterSource extends CsvReadableSource
{
    public function __construct()
    {
        parent::__construct(dirname(__DIR__) . '/data/master.csv');
    }

    protected function model(): string
    {
        return User::class;
    }
}
