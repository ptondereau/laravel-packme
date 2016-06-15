#!/usr/bin/env php
<?php

/**
 * Load correct autoloader depending on install location.
 */
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';
} else {
    require __DIR__.'/../../../autoload.php';
}

use Ptondereau\PackMe\Commands\CreateCommand;
use Silly\Edition\PhpDi\Application;

/*
 * Application bootstrap.
 */
$version = '2.0.0';

$app = new Application('Laravel PackMe', $version);

/*
 * Inject dependencies.
 */
$container = $app->getContainer();
$container->set(
    \Symfony\Component\Console\Helper\HelperSet::class,
    DI\object()->constructor(['question' => new \Symfony\Component\Console\Helper\QuestionHelper()])
);
$container->set(\Ptondereau\PackMe\Crafters\Crafter::class, DI\object(\Ptondereau\PackMe\Crafters\PHPCrafter::class));

/*
 * Create the package with user's answers.
 */
$app->command('create [dir]', [CreateCommand::class, 'handle'])
    ->descriptions('Create your package with a given directory', ['dir' => 'Your directory name']);

/*
 * Run the application.
 */
$app->run();
