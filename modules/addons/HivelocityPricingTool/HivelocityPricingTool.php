<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

require_once 'Autoloader.php';

function HivelocityPricingTool_config() {
    try {
        return \HivelocityPricingTool\classes\Addon::config();
    } catch (Exception $e) {
        return array('error' => $e->getMessage());
    }
}

function HivelocityPricingTool_output($params) {
    try {
        return \HivelocityPricingTool\classes\Addon::output($params);
    } catch (Exception $e) {
        return array('error' => $e->getMessage());
    }
}