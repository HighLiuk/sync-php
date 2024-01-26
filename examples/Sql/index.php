<?php

use Examples\Sql\UsersSqlSource;
use HighLiuk\Sync\Flow;

require_once __DIR__.'/../vendor/autoload.php';

Flow::from(UsersSqlSource::fromConnectionString('sqlite:'.__DIR__.'/data/master.db'))
    ->to(UsersSqlSource::fromConnectionString('sqlite:'.__DIR__.'/data/slave.db'))
    ->sync();
