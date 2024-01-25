<?php

use Examples\Csv\UsersMasterSource;
use Examples\Csv\UsersSlaveSource;
use HighLiuk\Sync\Sync;

require_once __DIR__.'/../vendor/autoload.php';

$master = new UsersMasterSource();
$slave = new UsersSlaveSource();
$sync = new Sync($master, $slave);

$sync->sync();
