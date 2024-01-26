<?php

use Examples\Sql\UsersSqlSource;
use HighLiuk\Sync\Sync;

require_once __DIR__.'/../vendor/autoload.php';

$master = UsersSqlSource::fromConnectionString('sqlite:'.__DIR__.'/data/master.db');
$slave = UsersSqlSource::fromConnectionString('sqlite:'.__DIR__.'/data/slave.db');
$sync = new Sync($master, $slave);

$sync->sync();
