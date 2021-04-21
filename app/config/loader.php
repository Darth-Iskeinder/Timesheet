<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->formDir,
        $config->application->libraryDir,
        $config->application->pluginsDir
    )
)->register();
date_default_timezone_set('Asia/Bishkek');