<?php

use Examples\Http\UsersHttpSource;
use HighLiuk\Sync\Flow;

require_once __DIR__.'/../vendor/autoload.php';

Flow::from(UsersHttpSource::fromUrl('http://localhost:3000/'))
    ->to(UsersHttpSource::fromUrl('http://localhost:3001/'))
    ->sync();
