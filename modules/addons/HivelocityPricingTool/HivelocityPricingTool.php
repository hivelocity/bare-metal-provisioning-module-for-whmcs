<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Database\Capsule;
require_once 'Autoloader.php';

function HivelocityPricingTool_config() {
    try {
        return \HivelocityPricingTool\classes\Addon::config();
    } catch (Exception $e) {
        return array('error' => $e->getMessage());
    }
}

function HivelocityPricingTool_activate() {

    if (!Capsule::schema()->hasTable('mod_hivelocity_cron')) {
        Capsule::schema()->create(
            'mod_hivelocity_cron',
            function ($table) {
                $table->increments('id');
                $table->string('value');
                $table->timestamps();
            }
        );
    }

    insert_query("mod_hivelocity_cron",array("value"=>'RunFiveMinCron',"created_at"=>date('Y-m-d h:i:s')));

}

function HivelocityPricingTool_deactivate() {

    Capsule::schema()->dropIfExists('mod_hivelocity_cron');

    return [
        'status' => 'success',
        'description' => 'Module deactivated & all the related data has been cleared.'
    ];
}

function HivelocityPricingTool_output($params) {
    try {
        return \HivelocityPricingTool\classes\Addon::output($params);
    } catch (Exception $e) {
        return array('error' => $e->getMessage());
    }
}