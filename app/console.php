#!/usr/bin/env php
<?php
/**
 * B2B connector console bootstrap file.
 */

use Connector\CommandKernel;

set_time_limit(0);
date_default_timezone_set('Europe/Moscow');

define('APP_DIR', __DIR__);

require_once(APP_DIR . '/../vendor/autoload.php');

$kernel = new CommandKernel('B2B-RAEC connector Command Line Interface', 'v0.2.0');
$kernel->handle();