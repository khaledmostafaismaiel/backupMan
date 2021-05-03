#!/usr/bin/env php
<?php
require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands
$application->add(new \Console\App\Commands\HelloWorldCommand());
$application->add(new \Console\App\Commands\BackupDatabaseCommand());
$application->add(new \Console\App\Commands\BackupSiteCommand());
$application->run();
