<?php

namespace Examples\Csv;

use HighLiuk\Sync\Adapters\Csv\CsvSource;

class UsersSlaveSource extends CsvSource
{
    public function __construct()
    {
        parent::__construct(dirname(__DIR__).'/data/slave.csv');
    }
}
