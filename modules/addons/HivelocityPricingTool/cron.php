<?php

require dirname(dirname(dirname(__DIR__))).'/init.php';
require_once 'Autoloader.php';

try {
    logModuleCall('high','cron','first',$argv);
    \HivelocityPricingTool\classes\Cron::priceChangeNotify();
    parse_str($argv[1], $params);
    if($params['fivemincron'])
    {
    	$q=mysql_query("SELECT value FROM mod_hivelocity_cron WHERE value='RunFiveMinCron'");
    	if(mysql_num_rows($q))
    	{
    		logModuleCall('high','cron','2nd',$params);
    		\HivelocityPricingTool\classes\Cron::synchronizeProducts();
    		mysql_query("DELETE FROM mod_hivelocity_cron WHERE value='RunFiveMinCron'");
    	}
    }
    else
    {
    	logModuleCall('high','cron','3rd','once a day');
    	\HivelocityPricingTool\classes\Cron::synchronizeProducts();
    }
    
} catch (Exception $e) {
    $loggedWhmcsUserId = $_SESSION["uid"];
    logActivity("HivelocityPricingTool: ".$e->getMessage(), $loggedWhmcsUserId);
}

