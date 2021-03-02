<?php

require dirname(dirname(dirname(__DIR__))).'/init.php';
require_once 'Autoloader.php';

try {
    
    \HivelocityPricingTool\classes\Cron::priceChangeNotify();
    
} catch (Exception $e) {
    $loggedWhmcsUserId = $_SESSION["uid"];
    logActivity("HivelocityPricingTool: ".$e->getMessage(), $loggedWhmcsUserId);
}

