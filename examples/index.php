<?php

use HighLiuk\Sync\Examples\Csv\Src\UsersSlaveSource;
use HighLiuk\Sync\Examples\Json\Src\UsersMasterSource;
use HighLiuk\Sync\Sync;

require_once __DIR__.'/../vendor/autoload.php';

$master = new UsersMasterSource();
$slave = new UsersSlaveSource();
$sync = new Sync($master, $slave);

$sync->sync();
