<?php

use Examples\Csv\UsersSlaveSource;
use Examples\Json\UsersMasterSource;
use HighLiuk\Sync\Sync;

require_once __DIR__.'/vendor/autoload.php';

$master = new UsersMasterSource();
$slave = new UsersSlaveSource();
$sync = new Sync($master, $slave);

$sync->sync();
