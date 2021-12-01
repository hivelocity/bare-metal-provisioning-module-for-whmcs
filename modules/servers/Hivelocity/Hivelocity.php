<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

require_once 'Autoloader.php';

function Hivelocity_MetaData() {
    return array(
        'DisplayName'                               => 'Hivelocity',
        'APIVersion'                                => '1.1',
        'RequiresServer'                            => true,
        'ListAccountsUniqueIdentifierField'         => 'domain',
    );
}

function Hivelocity_ConfigOptions($params) {
    try {
        return \Hivelocity\classes\Addon::getConfig($params);
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Hivelocity',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        if($_POST["action"] == "save") {
            return array();
        } else {
            throw $e;
        }
    }
}

function Hivelocity_CreateAccount($params) {
    try {
        \Hivelocity\classes\Addon::create($params);
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Hivelocity',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return $e->getMessage();
    }

    return 'success';
}

function Hivelocity_SuspendAccount($params) {
    return 'success';
}

function Hivelocity_UnsuspendAccount($params) {
    return 'success';
}

function Hivelocity_TerminateAccount($params) {
    try {
        \Hivelocity\classes\Addon::terminate($params);
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Hivelocity',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return $e->getMessage();
    }
    
    return 'success';
}

function Hivelocity_ClientArea($params) {
    try {
        return \Hivelocity\classes\Addon::clientArea($params);
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Hivelocity',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return;
    }
}

function Hivelocity_ClientAreaCustomButtonArray() {
    return array(
        "Boot"      => "boot",
        "Reboot"    => "reboot",
        "Shutdown"  => "shutdown",
        "Reinstall" => "Reload",
    );
}

function Hivelocity_AdminCustomButtonArray() {
    return array(
        "Boot"      => "Boot",
        "Reboot"    => "Reboot",
        "Shutdown"  => "Shutdown",
        "Reinstall" => "Reload",
    );
}

function Hivelocity_Boot($params) {
    try {
        \Hivelocity\classes\Addon::boot($params);
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Hivelocity',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return $e->getMessage();
    }
    
    return 'success';
}

function Hivelocity_Reboot($params) {
    try {
        \Hivelocity\classes\Addon::reboot($params);
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Hivelocity',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return $e->getMessage();
    }
    
    return 'success';
}

function Hivelocity_Shutdown($params) {
    try {
        \Hivelocity\classes\Addon::shutdown($params);
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Hivelocity',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return $e->getMessage();
    }
    
    return 'success';
}

function Hivelocity_Reload($params) {
    try {
        \Hivelocity\classes\Addon::reload($params);
    } catch (Exception $e) {
        // Record the error in WHMCS's module log.
        logModuleCall(
            'Hivelocity',
            __FUNCTION__,
            $params,
            $e->getMessage(),
            $e->getTraceAsString()
        );
        return $e->getMessage();
    }
    
    return 'success';
}

function Hivelocity_MetricProvider($params) {
    
    return new \Hivelocity\classes\MetricsProvider($params);
}