<?php

use Examples\Csv\UsersSlaveSource;
use Examples\Json\UsersMasterSource;
use HighLiuk\Sync\Flow;

require_once __DIR__.'/vendor/autoload.php';

Flow::from(new UsersMasterSource())
    ->to(new UsersSlaveSource())
    ->sync();
