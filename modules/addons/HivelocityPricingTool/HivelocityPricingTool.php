<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

require_once 'Autoloader.php';

use WHMCS\Database\Capsule;
use HivelocityPricingTool\classes\Addon;

function HivelocityPricingTool_config(): array
{
    try {
        return Addon::config();
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function HivelocityPricingTool_activate()
{
    Addon::databaseManagement();
}

function HivelocityPricingTool_deactivate(): array
{
    Capsule::schema()->dropIfExists('mod_hivelocity_cron');

    return [
        'status' => 'success',
        'description' => 'Module deactivated & all the related data has been cleared.'
    ];
}

function HivelocityPricingTool_output($params)
{
    try {
        return Addon::output($params);
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}