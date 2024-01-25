<?php

namespace Examples\Csv;

use HighLiuk\Sync\Adapters\Csv\CsvReadableSource;

class UsersMasterSource extends CsvReadableSource
{
    public function __construct()
    {
        parent::__construct(dirname(__DIR__).'/data/master.csv');
    }
}
