#!/usr/bin/env php
<?php

/**
 * Load correct autoloader depending on install location.
 */
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} else {
    require __DIR__ . '/../../../autoload.php';
}

use Silly\Edition\PhpDi\Application;

/*
 * Application bootstrap.
 */
$version = '1.0.0';

$app = new Application('Laravel PackMe', $version);

/**
 * Inject dependencies.
 */
$container = $app->getContainer();
$container->set(
    \Symfony\Component\Console\Helper\HelperSet::class,
    DI\object(\Symfony\Component\Console\Helper\HelperSet::class)
);

/**
 * Create the package with user's answers.
 */
$app->command('create [dir]', 'CreateCommand')
    ->descriptions('Create your package with a given directory', ['dir' => 'Your directory']);

/**
 * Run the application.
 */
$app->run();