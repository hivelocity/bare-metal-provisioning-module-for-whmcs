<?php
namespace Hivelocity\classes;
use Illuminate\Database\Capsule\Manager as Capsule;

class Addon {
    static public function getConfig($params) {
        
        Helpers::maintenanceDatabase();
        
        $productId          = $_POST["id"];
        $serverGroupId      = $_POST["servergroup"];
        
        if(empty($serverGroupId)) {
            
            $script = <<<SCRIPT
            <script>
                $("#noModuleSelectedRow").next().html('<td><div class="no-module-selected">Choose a server group to load configuration settings</div></td>');
            </script>
SCRIPT;
            
            return array(
                "noServer" => array (
                    "FriendlyName"  => "No Server",
                    "Type"          => "text",
                    "Size"          => "25",
                    "Description"   => $script,
                )
            );
        }
        
        $serverConfig       = Helpers::getServerConfigByServerGroupId($serverGroupId);
        
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        try {
            $remoteProductList  = Api::getProductList();
            $productOptions     = array();

            foreach($remoteProductList as $location => $list) {

                foreach($list as $remoteProduct) {

                    $remoteProductId            = $remoteProduct["product_id"];
                    $displayString              = $remoteProduct["product_id"]." - ".$remoteProduct["product_cpu"]." - ".$remoteProduct["product_memory"]." - ".$remoteProduct["product_drive"]." (".$remoteProduct["product_monthly_price"]." USD)";

                    $productOptions[$remoteProductId]  = $displayString;
                }
            }

            $billingInfoList    = Api::getBillingInfoList();

            $billingOptions     = array();

            foreach($billingInfoList as $billingInfo) {

                $billingOptions[$billingInfo["id"]] = $billingInfo["ccType"]." **** **** **** ".$billingInfo["ccNum"];
            }
            
        } catch(\Exception $e) {
            
            $script = <<<SCRIPT
            <script>
                $("#noModuleSelectedRow").next().html('<td><div class="no-module-selected">Server connection error</div></td>');
            </script>
SCRIPT;
            return array(
                "noServer" => array (
                    "FriendlyName"  => "No Server",
                    "Type"          => "text",
                    "Size"          => "25",
                    "Description"   => $script,
                )
            );
        }
        
        $script = <<<SCRIPT
            <script>
                var hivelocityProductId = $productId;
            </script>
            <script src="../modules/servers/Hivelocity/templates/js/modifyProductConfig.js" type="text/javascript"></script>
SCRIPT;
        
        $configArray = array(
            "product" => array (
                "FriendlyName"  => "Product",
                "Type"          => "dropdown",
                "Size"          => "25",
                "Options"       => $productOptions,
                "Description"   => $script,
            ),
            "" => array(),
            "billingInfo" => array (
                "FriendlyName"  => "Billing Info",
                "Type"          => "dropdown",
                "Size"          => "25",
                "Options"       => $billingOptions,
            ),
        );
        
        $remoteProductId        = Helpers::getRemoteProductIdByProductId($productId); 
        
        if($remoteProductId === false) {
            return $configArray;
        }
        try {
            $remoteProductDetails       = Api::getProductDetails($remoteProductId);
            $remoteProductOS            = Api::getProductOS($remoteProductId);
            $remoteProductOptions       = Api::getProductOptions($remoteProductId);
        } catch (\Exception $e) {
            return $configArray;
        }
        
//------------------------------------------------------------------------------         
        
        $locationOptions                    = array();
        
        foreach($remoteProductDetails as $location => $details) {
            
            $price                          = floatval($details[0]["monthly_location_premium"]);
            $displayString                  = Helpers::getLocationName($location);
            
            if(!empty($price)) {
                $price          = number_format($price, 2);
                $displayString .= " ($price USD)";
            }
            
            $locationOptions[$location]     = $displayString;
        }
        
        $configArray["location"]            = array(
            "FriendlyName"  => "Location",
            "Type"          => "dropdown",
            "Size"          => "25",
            "Options"       => $locationOptions,
        );
        
//------------------------------------------------------------------------------      
        
        $osOptions          = array();
        
        foreach($remoteProductOS as $os) {
            
            $price                          = floatval($os["monthlyPrice"]);
            $name                           = $os["name"];
            $displayString                  = $name;
            
            if(!empty($price)) {
                $price          = number_format($price, 2);
                $displayString .= " ($price USD)";
            }
            
            $osOptions[$name]               = $displayString;
        }
        
        $configArray["os"]  = array(
            "FriendlyName"      => "Operating System",
            "Type"              => "dropdown",
            "Size"              => "25",
            "Options"           => $osOptions,
        );
        
//------------------------------------------------------------------------------
        
        $remoteProductOptions = Helpers::filterProductOptions($remoteProductOptions);
        
        foreach($remoteProductOptions as $optionName => $subOptions) {
            
            $options = array();
            
            foreach($subOptions as $subOption) {
                $price                          = floatval($subOption["monthlyPrice"]);
                $name                           = $subOption["name"];
                $displayString                  = $name;

                if(!empty($price)) {
                    $price          = number_format($price, 2);
                    $displayString .= " ($price USD)";
                }
                
                $options[$subOption["id"]] = $displayString;
            }
            
            $configArray[$optionName]  = array(
                "FriendlyName"      => $optionName,
                "Type"              => "dropdown",
                "Size"              => "25",
                "Options"           => $options,
            );
        }
        
        return $configArray;
    }
    
    static public function create($params) {
        
        $apiUrl             = $params["serverhostname"];
        $apiKey             = $params["serveraccesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $serviceId          = $params["serviceid"];  
           
        //check if deployment exist---------------------------------------------
        
        $deploymentId       = Helpers::getHivelocityDeploymentCorrelation($serviceId);
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        
        
        if($deploymentId || $assignedDeviceId) {
            
            throw new \Exception("Deployment in progress or device exist.");
        }
        
        //----------------------------------------------------------------------
        
        $deploymentName     = "S".$serviceId."T".time();
        
        $response           = Api::createDeployment($deploymentName);
        $deploymentId       = $response["deploymentId"];
        
        $remoteProductId    = $params["configoption1"];
        
        if(isset($params["configoptions"]["Location"])) {
            $locationId     = $params["configoptions"]["Location"];
        } else {
            $locationId     = $params["configoption4"];
        }
        
        if(isset($params["configoptions"]["Operating System"])) {
            $osId           = $params["configoptions"]["Operating System"];
        } else {
            $osId           = $params["configoption5"];
        }
        
        $expectedOptions = array(
            "Control Panel",
            "Managed Services",
            "LiteSpeed",
            "WHMCS",
            "Bandwidth",
            "Load Balancing",
            "DDOS",
            "Daily Backup & Rapid Restore",
            "Cloud Storage",
            "Data Migration"
        );
        
        $options = array();
        
        if(isset($params["configoptions"]["Operating System"])) {               //config options exist, use config options
            
            foreach($expectedOptions as $optionName) {
                
                if(isset($params["configoptions"][$optionName]) && !empty($params["configoptions"][$optionName])) {
                
                    $options[]  = $params["configoptions"][$optionName];
                }
            }
            
        } else {                                                                //use admin area options
            
            for($i=6; $i<20; $i++) {
                
                if(isset($params["configoption".$i]) && !empty($params["configoption".$i])) { 
                
                    $options[]  = $params["configoption".$i];
                }
            }
        }
        
        $hostName           = $params["domain"];
        
        $serviceModel       = $params["model"];
        $serviceAttributes  = $serviceModel->getAttributes();
        $billingPeriod      = strtolower($serviceAttributes["billingcycle"]);
        
        $response           = Api::configureDeployment($deploymentId, $remoteProductId, $locationId, $osId, $options, $hostName, $billingPeriod);
        
        $billingInfoId      = $params["configoption3"];
        
        $response           = Api::executeDeployment($deploymentId, $billingInfoId);
        
        Helpers::saveHivelocityDeploymentCorrelation($serviceId, $deploymentId);
        
        $deploymentDetails  = Api::getDeploymentDetails($deploymentId);
        $hivelocityOrderId  = $deploymentDetails["orderNumber"];
        
        Helpers::saveHivelocityOrderCorrelation($serviceId, $hivelocityOrderId);
    }
    
    static public function terminate($params) {
        
        $apiUrl             = $params["serverhostname"];
        $apiKey             = $params["serveraccesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $serviceId          = $params["serviceid"];
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        
        if($assignedDeviceId === false) {
            throw new \Exception("Device is not assigned");
        }
        
        $deviceDetails      = Api::getDeviceDetails($assignedDeviceId);
        $remoteServiceId    = $deviceDetails["servicePlan"];
        
        //$correlatedServiceId    = Helpers::getHivelocityServiceCorrelation($serviceId);
        
        $response           = Api::cancelDevice($assignedDeviceId, $remoteServiceId);
    }
    
    static public function clientArea($params) {
        
        if(isset($_POST["hivelocityAction"])) {
            return;
        }
        
        Helpers::maintenanceDatabase();
        
        $apiUrl             = $params["serverhostname"];
        $apiKey             = $params["serveraccesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $serviceId          = $params["serviceid"];
        
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        $hivelocityOrderId  = Helpers::getHivelocityOrderCorrelation($serviceId);
        
        if($assignedDeviceId === false && $hivelocityOrderId !== false) {
            
            try {
                $orderDetails       = Api::getOrderDetails($hivelocityOrderId);
                $orderStatus        = $orderDetails["status"];
            } catch (\Exception $e) {
                $orderStatus        = "unknown";
            }
            
            if($orderStatus == "complete") {
                
                $remoteServiceList = Api::getServiceList();
                
                foreach($remoteServiceList as $remoteService) {
                    
                    if($remoteService["orderId"] == $hivelocityOrderId) {
                        
                        $remoteServiceId    = $remoteService["serviceId"];
                        
                        Helpers::saveHivelocityServiceCorrelation($serviceId, $remoteServiceId);
                        
                        $deviceId           = $remoteService["serviceDevices"][0]["id"];
                        Helpers::assignDevice($serviceId, $deviceId);
                        $deviceDetails      = Api::getDeviceDetails($deviceId);
                        $initialPassword    = Api::getInitialPassword($assignedDeviceId);
                        $orderStatus        = false;
                        
                        break;
                    }
                }
            }
        } else {
            $deviceDetails      = Api::getDeviceDetails($assignedDeviceId);
            //$initialPassword    = Api::getInitialPassword($assignedDeviceId);
            $initialPassword    = Api::getInitialPasswordLink($assignedDeviceId);
        }
        
        //ip temporary fix =====================================================
        
        $deviceList     = Api::getDeviceList();
        
        foreach($deviceList as $deviceDetails2) {
            
            if($deviceDetails2["deviceId"] == $assignedDeviceId) {
                
                $deviceDetails["primaryIp"] = $deviceDetails2["primaryIp"];
                break;
            }
        }
        
        //======================================================================
        
        $deviceDetails["ipAddresses"][] = $deviceDetails["primaryIp"];
        
        //IPMI Data=============================================================
        
        //$ipmiData   = Api::getIpmiData($assignedDeviceId);
        $userIp     = $_SERVER['REMOTE_ADDR'];
        
        ////DNS Data==============================================================
        //
        //$domainList             = Api::getDomainList();
        //$correlatedDomainIds    = Helpers::getHivelocityDomainCorrelationByServiceId($serviceId);
        //
        //
        //
        //foreach($domainList as $key => $domainData) {
        //    
        //    if(!in_array($domainData["domainId"], $correlatedDomainIds)) {
        //        
        //        unset($domainList[$key]);
        //    }
        //} 
        //
        ////======================================================================
        
        if(Helpers::isTwentyOne()) {
            $templateFile = 'templates/tpl/clientareatwentyone';
        } else {
            $templateFile = 'templates/tpl/clientareasix';
        }
        
        return array(
            'templatefile' => $templateFile,
            'vars' => array(
                'serviceId'         => $serviceId,
                'initialPassword'   => $initialPassword["password"],
                'deviceDetails'     => $deviceDetails,
                'orderStatus'       => ucwords($orderStatus),
                //'ipmiData'          => $ipmiData,
                'userIp'            => $userIp,
                //'domainList'        => $domainList,
            ),
        );
    }
    
    static public function boot($params) {
        
        $apiUrl             = $params["serverhostname"];
        $apiKey             = $params["serveraccesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $serviceId          = $params["serviceid"];
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        
        if($assignedDeviceId === false) {
            throw new \Exception("Device is not assigned");
        }
        
        Api::bootDevice($assignedDeviceId);
    }
    
    static public function reboot($params) {
        
        $apiUrl             = $params["serverhostname"];
        $apiKey             = $params["serveraccesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $serviceId          = $params["serviceid"];
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        
        if($assignedDeviceId === false) {
            throw new \Exception("Device is not assigned");
        }
        
        Api::rebootDevice($assignedDeviceId);
        
    }
    
    static public function shutdown($params) {
        
        $apiUrl             = $params["serverhostname"];
        $apiKey             = $params["serveraccesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $serviceId          = $params["serviceid"];
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        
        if($assignedDeviceId === false) {
            throw new \Exception("Device is not assigned");
        }
        
        Api::shutdownDevice($assignedDeviceId);
    }
    
    static public function reload($params) {
        
        $apiUrl             = $params["serverhostname"];
        $apiKey             = $params["serveraccesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $serviceId          = $params["serviceid"];
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        
        if($assignedDeviceId === false) {
            throw new \Exception("Device is not assigned");
        }
        
        if(isset($params["configoptions"]["Operating System"])) {
            $osName           = $params["configoptions"]["Operating System"];
        } else {
            $osName           = $params["configoption5"];
        }
        
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        $remoteProductId    = Helpers::getRemoteProductIdByProductId($productId);
        
        $remoteProductOS    = Api::getProductOS($remoteProductId);
        $osId               = false;
        
        foreach($remoteProductOS as $os) {
            
            if($os["name"] == $osName) {
                $osId = $os["id"];
                break;
            }
        }
        
        Api::reloadDevice($assignedDeviceId, $osId);
    }
}
