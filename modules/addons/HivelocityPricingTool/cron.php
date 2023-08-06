<?php

require dirname(__DIR__, 3) . '/init.php';
require_once 'Autoloader.php';

use HivelocityPricingTool\classes\Cron;

try {
    logModuleCall('high', 'cron', 'first', $argv);

    Cron::priceChangeNotify();

    logModuleCall('high', 'cron', '2nd', 'cron job setting');

    Cron::synchronizeProducts();
} catch (Exception $e) {
    $loggedWhmcsUserId = $_SESSION["uid"];

    logActivity("HivelocityPricingTool: " . $e->getMessage(), $loggedWhmcsUserId);
}
