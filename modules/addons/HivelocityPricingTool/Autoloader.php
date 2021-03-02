<?php
namespace HivelocityPricingTool;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function autoloader($class) {
    
    if(!defined('DS')) {
        define('DS', DIRECTORY_SEPARATOR);
    }
    
    $file = str_replace(__NAMESPACE__."\\", '', $class);
    $file = str_replace("\\", DS, $file);
    $file = $file.".php";
    
    $absolutePath = dirname(__FILE__).DS.$file;
    if(file_exists($absolutePath)) {
        include_once $file;
    }
}
spl_autoload_register('HivelocityPricingTool\autoloader');
