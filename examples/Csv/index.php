<?php

use Examples\Csv\UsersMasterSource;
use Examples\Csv\UsersSlaveSource;
use HighLiuk\Sync\Flow;

require_once __DIR__.'/../vendor/autoload.php';

Flow::from(new UsersMasterSource())
    ->to(new UsersSlaveSource())
    ->sync();
