<?php

namespace Hivelocity\classes;

class Hooks {
    static function adminActions($params) {
        if(isset($_POST["hivelocityAction"]) && !empty($_POST["hivelocityAction"])) {
            $action = $_POST["hivelocityAction"];
        } else {
            return;
        }
        
        try {
            if($action == "createConfigOptions") {

                $productId          = $_POST["hivelocityProductId"];
                $remoteProductId    = $_POST["hivelocityRemoteProductId"];

                $returnArray        = Actions::createConfigOptions($productId, $remoteProductId);
                
                echo json_encode($returnArray);
                die;
            }
            
            die;
            
        } catch(\Exception $e) {
            
            $returnArray = array("result" => "error", "message" => $e->getMessage());
                
            echo json_encode($returnArray);
            die;
        }
    }
    
    static function userActions($params) {
        
        if(isset($_POST["hivelocityAction"]) && !empty($_POST["hivelocityAction"])) {
            $action = $_POST["hivelocityAction"];
        } else {
            return;
        }
        
        $loggedUserId = $_SESSION["uid"];
        
        if($action == "getBandwidth") {
            
            $serviceId          = $_POST["hivelocityServiceId"];
            $period             = $_POST["hivelocityPeriod"];
            $customPeriod       = $_POST["hivelocityCustomPeriod"];
            
            $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
            
            if(empty($loggedUserId || $loggedUserId != $serviceUserId)) {
                die;
            }
            
            Actions::getBandwidth($serviceId, $period, $customPeriod);
        }
        die;
    }
    
    static function addProductCustomFields($params) {
        
        $productId      = $params["pid"];
        
        $productModule  = Helpers::getProductModule($productId);
        
        if($productModule != "Hivelocity") {
            return;
        }
        
        $customFieldId  = Helpers::getProductCustomFieldId($productId);
        if($customFieldId === false){
            Helpers::addProductCustomField($productId);
        }
    }
    
    static function modifyServicePage($params) {
        
        if(strpos($_SERVER["REQUEST_URI"], "clientsservices.php") === false){
            return;
        }
        
        if(isset($_GET["productselect"]) && !empty($_GET["productselect"])) {
            $serviceId  = $_GET["productselect"];
        } else if(isset($_GET["id"]) && !empty($_GET["id"])) {
            $serviceId  = $_GET["id"];
        } else {
            $userId     = $_GET["userid"];
            $serviceId  = Helpers::getFirstServiceId($userId);
        }
        
        if(!Helpers::isHivelocityService($serviceId)) {
            return;
        }
        
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
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
                        
                        if(empty($deviceId)) {
                            $assignedDeviceId = false;
                            break;
                        }
                        
                        Helpers::assignDevice($serviceId, $deviceId);
                        $assignedDeviceId   = $deviceId;
                        
                        header('Location: '.$_SERVER['REQUEST_URI']); //refresh page to show device id in custom field
                        
                        break;
                    }
                }
            }
        }
        
        if($assignedDeviceId !== false) {
            $deviceOptions      = "<option value='$assignedDeviceId' selected>$assignedDeviceId</option>";
        } else {
            $deviceOptions      = "";
        }
        
        $deviceList         = Api::getDeviceList();

        foreach($deviceList as $device) {
            $deviceId = $device["deviceId"];
            if(!Helpers::isDeviceAssigned($deviceId)) {
                $deviceOptions .= "<option value='$deviceId'>$deviceId</option>";
            }
        }
        
        $customFieldId = Helpers::getProductCustomFieldId($productId);
        
        $selectHtml    = "<select name='customfield[$customFieldId]' id='customfield$customFieldId' value='' class='form-control select-inline' style='width:400px'>$deviceOptions</select>";
        
        $script = <<<SCRIPT
            <script>
                var hivelocityProductId         = $productId;
                var hivelocityCustomFieldId     = $customFieldId;
                var hivelocityDeviceSelectHtml  = "$selectHtml";
            </script>
            <script src="../modules/servers/Hivelocity/templates/js/modifyServicePage.js" type="text/javascript"></script>
SCRIPT;
        
        return $script;
    }
    
    static function modifyCartConfProductPage($params) {
        
        if(!isset($_GET["a"])||$_GET["a"] != "confproduct") {
            return;
        }
        
        $itemIndex      = $_GET["i"];
        
        $productId      = $_SESSION["cart"]["products"][$itemIndex]["pid"];
        $productModule  = Helpers::getProductModule($productId);
        
        if($productModule != "Hivelocity") {
            return;
        }
        
        $remoteProductId    = Helpers::getRemoteProductIdByProductId($productId);
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $remoteProductDetails           = Api::getProductDetails($remoteProductId);
        
        $configOptionGroupId            = Helpers::getConfigOptionsGroupId($productId);
        $locationConfigOptionId         = Helpers::getConfigOptionId($configOptionGroupId, "Location");
        $locationConfigOptionsSubList   = Helpers::getConfigOptionSubList($locationConfigOptionId);
        
        $locationAvailability           = array();
        
        foreach($locationConfigOptionsSubList as $locationConfigOptionsSub) {
            
            $locationConfigOptionSubId  = $locationConfigOptionsSub["id"];
            $temp                       = explode("|",$locationConfigOptionsSub["optionname"]);
            $locationCode               = $temp[0];
            
            if(isset($remoteProductDetails[$locationCode][0]["stock"]) && !empty($remoteProductDetails[$locationCode][0]["stock"])) {
                $locationAvailability[$locationConfigOptionSubId] = $remoteProductDetails[$locationCode][0]["stock"];
            } else {
                $locationAvailability[$locationConfigOptionSubId] = "unavailable";
            }
        }
        
        $expectedOptions = array(
            "Location",
            "Operating System",
            "Control Panel",
            "Managed Services",
            "LiteSpeed",
            "WHMCS",
            "Bandwidth",
            "Load Balancing",
            "DDOS",
            "Daily Backup & Rapid Restore",
            "Cloud Storage",
            "Data Migration",
        );
        
        $configOptionIds = array();
        
        foreach($expectedOptions as $optionName) {
            $configOptionFieldIds[$optionName] =  'inputConfigOption'.Helpers::getConfigOptionId($configOptionGroupId, $optionName);
        }
        
        $configOptionFieldIdsJson   = json_encode($configOptionFieldIds);
        $locationAvailabilityJson   = json_encode($locationAvailability);
        
        $script = <<<SCRIPT
            <script>
                var hivelocityConfigOptionFieldsIdsJson = '$configOptionFieldIdsJson';
                var hivelocityLocationAvailability      = '$locationAvailabilityJson';
            </script>
            <script src="modules/servers/Hivelocity/templates/js/modifyCartConfProductPage.js" type="text/javascript"></script>
SCRIPT;
        
        return $script;
    }
}
