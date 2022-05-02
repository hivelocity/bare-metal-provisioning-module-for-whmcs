<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

add_hook('AdminAreaPage', 1, function($params) {
    
    require_once 'Autoloader.php';
    
    try {
        return \Hivelocity\classes\Hooks::adminActions($params);
    } catch (Exception $e) {}
});

add_hook('ClientAreaPage', 1, function($params) {
    
    require_once 'Autoloader.php';
    
    try {
        return \Hivelocity\classes\Hooks::userActions($params);
    } catch (Exception $e) {}
});

add_hook('ClientAreaPageCancellation', 1, function($params) {
    
    require_once 'Autoloader.php';
    
    try {
        return \Hivelocity\classes\Hooks::cancelRequestPage($params);
    } catch (Exception $e) {}
});

add_hook('ClientAreaFooterOutput', 1, function($params) {
    
    require_once 'Autoloader.php';
    
    try {
        return \Hivelocity\classes\Hooks::modifyCartConfProductPage($params);
    } catch (Exception $e) {}
});


add_hook('AdminProductConfigFieldsSave', 1, function($params) {
    
    require_once 'Autoloader.php';
    
    try {
        return \Hivelocity\classes\Hooks::addProductCustomFields($params);
    } catch (Exception $e) {}
});

add_hook('AdminAreaFooterOutput', 1, function($params) {
    
    require_once 'Autoloader.php';
    
    try {
        return \Hivelocity\classes\Hooks::modifyServicePage($params);
    } catch (Exception $e) {}
});