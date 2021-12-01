<?php
namespace Hivelocity\classes;
use Illuminate\Database\Capsule\Manager as Capsule;

class Actions {
    
    static public function createConfigOptions($productId, $remoteProductId) {
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $remoteProductDetails   = Api::getProductDetails($remoteProductId);
        $remoteProductOS        = Api::getProductOS($remoteProductId);
        $remoteProductOptions   = Api::getProductOptions($remoteProductId);
        
        $configOptionsGroupId   = Helpers::getConfigOptionsGroupId($productId);
        $newGroup               = false;
        
        if($configOptionsGroupId == false) {
            $configOptionsGroupId   = Helpers::createConfigOptionsGroup($productId);
            $newGroup               = true;
        }
        
        $configOptionsLinkId = Helpers::getConfigOptionsLinkId($productId, $configOptionsGroupId);
        if($configOptionsLinkId == false) {
            Helpers::createConfigOptionsLink($productId, $configOptionsGroupId);
        }
        
        $currencyId = Helpers::getCurrencyId("USD");
        
        if($currencyId == false) {
            throw new \Exception("Currency 'USD' Not Configured");
        }
        
//------------------------------------------------------------------------------
        
        $locationConfigOptionId = Helpers::getConfigOptionId($configOptionsGroupId, "Location");
        if($locationConfigOptionId == false) {
            Helpers::createConfigOption($configOptionsGroupId, "Location");
            $locationConfigOptionId = Helpers::getConfigOptionId($configOptionsGroupId, "Location");
        }
        
        Helpers::clearConfigOptionSub($locationConfigOptionId);
        
        foreach($remoteProductDetails as $location => $details) {
            
            $name               = $location."|".Helpers::getLocationName($location);
            
            Helpers::createConfigOptionSub($locationConfigOptionId, $name);
            
            $configOptionSubId  = Helpers::getConfigOptionSubId($locationConfigOptionId, $name);
            $price              = floatval($details[0]["monthly_location_premium"]);
            
            $usdRate            = Helpers::getCurrencyRate("USD");
            $basePrice          = $price / $usdRate;
            
            $currencyList       = Helpers::getCurrencyList();
            foreach($currencyList as $currency) {
                $currencyId     = $currency["id"];
                $currencyRate   = $currency["rate"];
                $priceConverted = $basePrice * $currencyRate;
                Helpers::addConfigOptionPrice($configOptionSubId, $priceConverted, $currencyId);
            }
        }
        
//------------------------------------------------------------------------------
        
        $osConfigOptionId = Helpers::getConfigOptionId($configOptionsGroupId, "Operating System");
        if($osConfigOptionId == false) {
            Helpers::createConfigOption($configOptionsGroupId, "Operating System");
            $osConfigOptionId = Helpers::getConfigOptionId($configOptionsGroupId, "Operating System");
        }
         
        Helpers::clearConfigOptionSub($osConfigOptionId);
        
        foreach($remoteProductOS as $os) {
            
            $name               = $os["name"]."|".$os["name"];
            
            Helpers::createConfigOptionSub($osConfigOptionId, $name);
            
            $configOptionSubId  = Helpers::getConfigOptionSubId($osConfigOptionId, $name);
            $price              = floatval($os["monthlyPrice"]);
            
            $usdRate            = Helpers::getCurrencyRate("USD");
            $basePrice          = $price / $usdRate;
            
            $currencyList       = Helpers::getCurrencyList();
            
            foreach($currencyList as $currency) {
                $currencyId     = $currency["id"];
                $currencyRate   = $currency["rate"];
                $priceConverted = $basePrice * $currencyRate;
                Helpers::addConfigOptionPrice($configOptionSubId, $priceConverted, $currencyId);
            }
        }
        
//------------------------------------------------------------------------------
        
        $remoteProductOptions = Helpers::filterProductOptions($remoteProductOptions);
        
        foreach($remoteProductOptions as $optionName => $subOptions) {
            
            $configOptionId = Helpers::getConfigOptionId($configOptionsGroupId, $optionName);
            
            if($configOptionId == false) {
                Helpers::createConfigOption($configOptionsGroupId, $optionName);
                $configOptionId = Helpers::getConfigOptionId($configOptionsGroupId, $optionName);
            }
            
            Helpers::clearConfigOptionSub($configOptionId);
            
            foreach($subOptions as $subOption) {
                
                $name               = $subOption["id"]."|".$subOption["name"];

                Helpers::createConfigOptionSub($configOptionId, $name);

                $configOptionSubId  = Helpers::getConfigOptionSubId($configOptionId, $name);
                $price              = floatval($subOption["monthlyPrice"]);

                $usdRate            = Helpers::getCurrencyRate("USD");
                $basePrice          = $price / $usdRate;

                $currencyList       = Helpers::getCurrencyList();

                foreach($currencyList as $currency) {
                    $currencyId     = $currency["id"];
                    $currencyRate   = $currency["rate"];
                    $priceConverted = $basePrice * $currencyRate;
                    Helpers::addConfigOptionPrice($configOptionSubId, $priceConverted, $currencyId);
                }
            }
        }

//------------------------------------------------------------------------------
        
        $groupName          = Helpers::getConfigOptionsGroupName($configOptionsGroupId);
        $groupOptionHtml    = '<option selected value="'.$configOptionsGroupId.'">'.$groupName.'</option>';
        
        
        $returnArray        = array(
            "result"            => "success",
            "groupId"           => $configOptionsGroupId,
            "newGroup"          => $newGroup,
            "groupOptionHtml"   => $groupOptionHtml
        );
        
        return $returnArray;
    }
    
    static public function getBandwidth($serviceId, $period, $customPeriod) {
        
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        
        $temp               = explode("-",$customPeriod);
        
        $startDateString    = trim($temp[0]);
        $EndDateString      = trim($temp[1]);  
            
        $start              = strtotime($startDateString);
        $end                = strtotime($EndDateString);
        
        $bandwidthDetails = Api::getBandwidthDetails($assignedDeviceId, $period, $start, $end); 
        
        $bandwidthDetails[0]["metadata"]["totals"]["In_95th"]   = $bandwidthDetails[0]["metadata"]["totals"]["In 95th"];
        $bandwidthDetails[0]["metadata"]["totals"]["Out_95th"]  = $bandwidthDetails[0]["metadata"]["totals"]["Out 95th"];
        
        
        $bandwidthDetailsJson = json_encode($bandwidthDetails[0]);
        echo $bandwidthDetailsJson;
        die;
    }
    
    static public function addDomain($serviceId, $domainName) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $response           = Api::addDomain($domainName);
        
        $hivelocityDomainId = $response["domainId"];
        
        Helpers::saveHivelocityDomainCorrelation($serviceId, $serviceUserId, $hivelocityDomainId);
         
        $return     = array(
            "result"                => "success",
            "domainName"            => $domainName,
            "hivelocityDomainId"    => $hivelocityDomainId,
        );
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }
    
    static public function removeDomain($serviceId, $hivelocityDomainId) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $response           = Api::removeDomain($hivelocityDomainId);
        
        Helpers::removeHivelocityDomainCorrelation($hivelocityDomainId);
         
        $return     = array(
            "result"                => "success",
        );
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }
    
    static public function addRecord($serviceId, $hivelocityDomainId, $hivelocityRecordType, $hivelocityRecordData) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $response           = Api::addRecord($hivelocityDomainId, $hivelocityRecordType, $hivelocityRecordData);
        
        $hivelocityDomainId = $response["domainId"];
        
        $return             = array(
            "result"                => "success",
            "hivelocityRecordData"  => $response,
        );
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }
    
    static public function editRecord($serviceId, $hivelocityDomainId, $hivelocityRecordType, $hivelocityRecordId, $hivelocityRecordData) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $response           = Api::editRecord($hivelocityDomainId, $hivelocityRecordType, $hivelocityRecordId, $hivelocityRecordData);
        
        $hivelocityDomainId = $response["domainId"];
        
        $return             = array(
            "result"                => "success",
            "hivelocityRecordData"  => $response,
        );
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }
    
    static public function removeRecord($serviceId, $hivelocityDomainId, $hivelocityRecordType, $hivelocityRecordId) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $response           = Api::removeRecord($hivelocityDomainId, $hivelocityRecordType, $hivelocityRecordId);
        
        $return     = array(
            "result"                => "success",
        );
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }
    
    static public function getDnsData($serviceId, $hivelocityDomainId) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $return     = array(
            "result"                => "success",
        );
        
        $recordTypes        = array(
            "a-record",
            "aaaa-record",
            "mx-record",
        //    "ptr",
        ); 
        
        foreach ($recordTypes as $recordType) {
            $response               = Api::getDnsRecordList($hivelocityDomainId, $recordType);
            $return[$recordType]    = $response;
        }
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
        
    }
    
    static public function allowIp($serviceId, $ip) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        
        $response           = Api::allowIp($assignedDeviceId, $ip);
        
        $return     = array(
            "result"                => "success",
            "ipmiPageIp"            => $response,
        );
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
        
    }
}
