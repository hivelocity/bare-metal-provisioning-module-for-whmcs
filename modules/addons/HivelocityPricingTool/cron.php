<?php

require dirname(__DIR__, 3) . '/init.php';
require_once 'Autoloader.php';

use HivelocityPricingTool\classes\Cron;
use HivelocityPricingTool\classes\Helpers;

try {
    logModuleCall('high', 'cron', 'first', $argv);
    Cron::priceChangeNotify();
    parse_str($argv[1], $params);
    if ($params['fivemincron']) {
        if (Helpers::isRunFiveMinCronExist()) {
            logModuleCall('high', 'cron', '2nd', $params);
            Cron::synchronizeProducts();
            Helpers::deleteRunFiveMinCron();
        }
    } else {
        logModuleCall('high', 'cron', '3rd', 'once a day');
        Cron::synchronizeProducts();
    }
} catch (Exception|Throwable $e) {
    $loggedWhmcsUserId = $_SESSION["uid"];
    logActivity("HivelocityPricingTool: " . $e->getMessage(), $loggedWhmcsUserId);
}

