<?php

use Examples\Json\UsersMasterSource;
use Examples\Json\UsersSlaveSource;
use HighLiuk\Sync\Sync;

require_once __DIR__.'/../vendor/autoload.php';

$master = new UsersMasterSource();
$slave = new UsersSlaveSource();
$sync = new Sync($master, $slave);

$sync->sync();
