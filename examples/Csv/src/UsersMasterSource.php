<?php

namespace HighLiuk\Sync\Examples\Csv\Src;

use HighLiuk\Sync\Adapters\Csv\CsvReadableSource;

class UsersMasterSource extends CsvReadableSource
{
    public function __construct()
    {
        parent::__construct(dirname(__DIR__) . '/data/master.csv');
    }
}
