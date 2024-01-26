<?php

use Examples\Http\UsersHttpSource;
use HighLiuk\Sync\Sync;

require_once __DIR__.'/../vendor/autoload.php';

$master = UsersHttpSource::fromUrl('http://localhost:3000/');
$slave = UsersHttpSource::fromUrl('http://localhost:3001/');
$sync = new Sync($master, $slave);

$sync->sync();
