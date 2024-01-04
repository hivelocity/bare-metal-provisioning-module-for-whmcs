<?php

require dirname(dirname(dirname(__DIR__))).'/init.php';
require_once 'Autoloader.php';

try {
    logModuleCall('Hivelocity','cron','cron started', "");
    \HivelocityPricingTool\classes\Cron::priceChangeNotify();
    \HivelocityPricingTool\classes\Cron::synchronizeProducts();
    logModuleCall('Hivelocity','cron','cron completed', "");
    
} catch (Exception $e) {
    $loggedWhmcsUserId = $_SESSION["uid"];
    logActivity("HivelocityPricingTool: ".$e->getMessage(), $loggedWhmcsUserId);
}

