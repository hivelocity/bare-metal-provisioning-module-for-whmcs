<?php

require dirname(dirname(dirname(__DIR__))).'/init.php';
require_once 'Autoloader.php';

try {    
    parse_str($argv[1], $params);   

    if($params['fivemincron'])
    {
    	$q=mysql_query("SELECT value FROM mod_hivelocity_cron WHERE value='RunFiveMinCron'");
    	if(mysql_num_rows($q))
    	{
            logModuleCall("HivelocityPricingTool","Cron", "5 Min cron",$params);
    		\HivelocityPricingTool\classes\Cron::synchronizeProducts();
            mysql_query("DELETE FROM mod_hivelocity_cron WHERE value='RunFiveMinCron'");
            \HivelocityPricingTool\classes\Cron::priceChangeNotify();
    	}
    }else
    {
        logModuleCall("HivelocityPricingTool","Cron", "All Records",$params);
    	\HivelocityPricingTool\classes\Cron::synchronizeProducts();
        \HivelocityPricingTool\classes\Cron::priceChangeNotify();
    }
} catch (Exception $e) {
    
    $loggedWhmcsUserId = $_SESSION["uid"];
    logActivity("HivelocityPricingTool: ".$e->getMessage(), $loggedWhmcsUserId);
}



