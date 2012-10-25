<?php

/* set start time */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);
$mem_usage = memory_get_usage();

/* @var $modx modX */

if (!defined('MODX_CORE_PATH')) {
    $path1 = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/_build/build.config.php';
    if (file_exists($path1)) {
        include $path1;
    } else {
        $path2 = dirname(dirname(dirname(dirname(__FILE__)))) . '/_build/build.config.php';
        if (file_exists($path2)) {
            include($path2);
        }
    }
    if (!defined('MODX_CORE_PATH')) {
        die('[bootstrap.php] Could not find build.config.php');
    }
    require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
    $modx = new modX();
    /* Initialize and set up logging */
    $modx->initialize('mgr');
    $modx->setLogLevel(xPDO::LOG_LEVEL_INFO);
    $modx->setLogTarget(XPDO_CLI_MODE
        ? 'ECHO'
        : 'HTML');

    /* This section will only run when operating outside of MODX */
    if (php_sapi_name() == 'cli') {
        /* Set $modx->user and $modx->resource to avoid
         * other people's plugins from crashing us */
        $modx->getRequest();
        $homeId = $modx->getOption('site_start');
        $homeResource = $modx->getObject('modResource', $homeId);

        if ($homeResource instanceof modResource) {
            $modx->resource = $homeResource;
        } else {
            echo "\nNo Resource\n";
        }
    } else {
        echo "\n<pre>\n";
    }
} else {
    echo "\n<pre>\n";
}

require_once $modx->getOption('mc.core_path', null, $modx->getOption('core_path') . 'components/mycomponent/') . 'model/mycomponent/mycomponentproject.class.php';

$project = new MyComponentProject($modx);
$project->init();

//$project->removeObjects();
$project->bootstrap();

// echo print_r(ObjectAdapter::$myObjects, true);

echo "\n\nInitial Memory Used: " . round($mem_usage / 1048576, 2) . " megabytes";
$mem_usage = memory_get_usage();
$peak_usage = memory_get_peak_usage(true);
echo "\nFinal Memory Used: " . round($mem_usage / 1048576, 2) . " megabytes";
echo "\nPeak Memory Used: " . round($peak_usage / 1048576, 2) . " megabytes";
/* report how long it took */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tend = $mtime;
$totalTime = ($tend - $tstart);
$totalTime = sprintf("%2.4f s", $totalTime);
echo "\nTotal time: " . $totalTime;

