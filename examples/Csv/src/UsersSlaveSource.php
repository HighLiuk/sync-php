<?php

namespace HighLiuk\Sync\Examples\Csv\Src;

use HighLiuk\Sync\Adapters\Csv\CsvSource;

/**
 * @extends CsvSource<User>
 */
class UsersSlaveSource extends CsvSource
{
    public function __construct()
    {
        parent::__construct(dirname(__DIR__) . '/data/slave.csv');
    }

    protected function model(): string
    {
        return User::class;
    }
}
