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
        
        // Collect all processed options: location, OS, other options like bandwidth etc.
        $processedOptions       = array();    
        //------------------------------------------------------------------------------
        

        // Handle Location option
        // If location exist, update pricing
        // If it doesn't exist, add and create pricing
        $locationConfigOptionId = Helpers::getConfigOptionId($configOptionsGroupId, "Location");
        if($locationConfigOptionId == false) {
            Helpers::createConfigOption($configOptionsGroupId, "Location");
            $locationConfigOptionId = Helpers::getConfigOptionId($configOptionsGroupId, "Location");
        }

        $processedSubOptions    = array();

        foreach($remoteProductDetails as $location => $details) {
            
            $name               = $location."|".Helpers::getLocationName($location);
            $configOptionSubId  = Helpers::getConfigOptionSubId($locationConfigOptionId, $name);
            
            if($configOptionSubId == false) {
                
                Helpers::createConfigOptionSub($locationConfigOptionId, $name);
                $configOptionSubId  = Helpers::getConfigOptionSubId($locationConfigOptionId, $name);
            }
            
            $price              = floatval($details[0]["monthly_location_premium"]);
            
            $usdRate            = Helpers::getCurrencyRate("USD");
            $basePrice          = $price / $usdRate;
            
            $currencyList       = Helpers::getCurrencyList();
            foreach($currencyList as $currency) {
                $currencyId     = $currency["id"];
                $currencyRate   = $currency["rate"];
                $priceConverted = $basePrice * $currencyRate;
                Helpers::setConfigOptionPrice($configOptionSubId, $priceConverted, $currencyId);
            }
            
            $processedSubOptions[] = $configOptionSubId;
        }

        $localConfigOptionSubList   = Helpers::getConfigOptionSubList($locationConfigOptionId);
            
        foreach($localConfigOptionSubList as $localConfigOptionSubData) {

            $localConfigOptionSubId     = $localConfigOptionSubData["id"];

            if(in_array($localConfigOptionSubId, $processedSubOptions)) {

                Helpers::unHideConfigOptionSub($localConfigOptionSubId);

            } else {

                Helpers::hideConfigOptionSub($localConfigOptionSubId);
            }
        }

        // Add Location to processed options
        $processedOptions[]         = $locationConfigOptionId;
        //------------------------------------------------------------------------------

        
        // Handle Operating System option
        // If OS exist, update pricing
        // If it doesn't exist, add and create pricing
        $osConfigOptionId = Helpers::getConfigOptionId($configOptionsGroupId, "Operating System");
        if($osConfigOptionId == false) {
            Helpers::createConfigOption($configOptionsGroupId, "Operating System");
            $osConfigOptionId = Helpers::getConfigOptionId($configOptionsGroupId, "Operating System");
        }
         
        $processedSubOptions    = array();

        foreach($remoteProductOS as $os) {
            
            $name               = $os["name"]."|".$os["name"];
            $configOptionSubId  = Helpers::getConfigOptionSubId($osConfigOptionId, $name);
            
            if($configOptionSubId == false) {
                
                Helpers::createConfigOptionSub($osConfigOptionId, $name);
                $configOptionSubId  = Helpers::getConfigOptionSubId($osConfigOptionId, $name);
            }
            
            $price              = floatval($os["monthlyPrice"]);
            
            $usdRate            = Helpers::getCurrencyRate("USD");
            $basePrice          = $price / $usdRate;
            
            $currencyList       = Helpers::getCurrencyList();
            
            foreach($currencyList as $currency) {
                $currencyId     = $currency["id"];
                $currencyRate   = $currency["rate"];
                $priceConverted = $basePrice * $currencyRate;
                Helpers::setConfigOptionPrice($configOptionSubId, $priceConverted, $currencyId);
            }
            
            $processedSubOptions[] = $configOptionSubId;
        }

        $localConfigOptionSubList   = Helpers::getConfigOptionSubList($osConfigOptionId);
            
        foreach($localConfigOptionSubList as $localConfigOptionSubData) {

            $localConfigOptionSubId     = $localConfigOptionSubData["id"];

            if(in_array($localConfigOptionSubId, $processedSubOptions)) {

                Helpers::unHideConfigOptionSub($localConfigOptionSubId);

            } else {

                Helpers::hideConfigOptionSub($localConfigOptionSubId);
            }
        }

        // Add OS to processed options
        $processedOptions[]         = $osConfigOptionId;
        //------------------------------------------------------------------------------
        

        // Handle all other options
        // If option exist, update pricing
        // If it doesn't exist, add and create pricing
        $remoteProductOptions   = Helpers::filterProductOptions($remoteProductOptions);

        foreach($remoteProductOptions as $optionName => $subOptions) {
            
            $configOptionId = Helpers::getConfigOptionId($configOptionsGroupId, $optionName);
            
            if($configOptionId == false) {
                Helpers::createConfigOption($configOptionsGroupId, $optionName);
                $configOptionId = Helpers::getConfigOptionId($configOptionsGroupId, $optionName);
            }
            
            $processedSubOptions    = array();
            
            foreach($subOptions as $subOption) {
                
                $name               = $subOption["id"]."|".$subOption["name"];
                $configOptionSubId  = Helpers::getConfigOptionSubId($configOptionId, $name);
                
                if($configOptionSubId == false) {
                    
                    Helpers::createConfigOptionSub($configOptionId, $name);
                    $configOptionSubId  = Helpers::getConfigOptionSubId($configOptionId, $name);
                }
                
                $price              = floatval($subOption["monthlyPrice"]);

                $usdRate            = Helpers::getCurrencyRate("USD");
                $basePrice          = $price / $usdRate;

                $currencyList       = Helpers::getCurrencyList();

                foreach($currencyList as $currency) {
                    $currencyId         = $currency["id"];
                    $currencyRate       = $currency["rate"];
                    $priceConverted     = $basePrice * $currencyRate;
                    Helpers::setConfigOptionPrice($configOptionSubId, $priceConverted, $currencyId);
                }
                $processedSubOptions[]  = $configOptionSubId;
            }
            
            $localConfigOptionSubList   = Helpers::getConfigOptionSubList($configOptionId);
            
            foreach($localConfigOptionSubList as $localConfigOptionSubData) {

                $localConfigOptionSubId     = $localConfigOptionSubData["id"];

                if(in_array($localConfigOptionSubId, $processedSubOptions)) {

                    Helpers::unHideConfigOptionSub($localConfigOptionSubId);

                } else {

                    Helpers::hideConfigOptionSub($localConfigOptionSubId);
                }
            }
            
            // Add option to processed options
            $processedOptions[]     = $configOptionId;
        }
        //------------------------------------------------------------------------------
        

        // Processing all options, hide/unhide
        $localConfigOptionList   = Helpers::getConfigOptionList($configOptionsGroupId);
            
        foreach($localConfigOptionList as $localConfigOptionData) {

            $localConfigOptionId     = $localConfigOptionData["id"];

            if(in_array($localConfigOptionId, $processedOptions)) {

                Helpers::unHideConfigOption($localConfigOptionId);

            } else {

                Helpers::hideConfigOption($localConfigOptionId);
            }
        }

        // Return new group if created
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

    static public function createVLAN($serviceId, $type,$code) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $response           = Api::createVLAN($type, $code); // 45.158.37.216/29
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        $ports= Api::getPorts($assignedDeviceId);
        foreach ($ports as $key => $value) {
            if($value['type']=='Bond Interface')
                $portarr[]=$value['portId'];
        }

        //$res=Api::modifyVLAN(array('portIds' => $portarr,'ipIds' => array()),$response['vlanId']);
        ///$res=Api::Bond($assignedDeviceId);
        $return     = array(
            "result"                => "success",
            "response"            => $response,
        );
        logModuleCall('createVLAN',$serviceId,$res,$response);
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }
    
    static public function removeVlan($serviceId, $vlanid) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $response           = Api::removeVLAN($vlanid);
                 
        $return     = array(
            "result"                => "success",
        );
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }

    static public function routeVlan($serviceId, $vlanId) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        $ports= Api::getPorts($assignedDeviceId);
        foreach ($ports as $key => $value) {
            if($value['type']=='Bond Interface')
                $portarr[]=$value['portId'];
        }

        $response=Api::modifyVLAN(array('portIds' => $portarr,'ipIds' => array()),$vlanId);
        ///$res=Api::Bond($assignedDeviceId);
        $response=json_decode($response['metaData']);
        $vlan=Api::getVLAN($response->vlan_id);
        $res['vlanid']=$response->vlan_id;
        $res['vlan']='VLAN Tag #'.$vlan['vlanTag'].' '.$vlan['facilityCode'];

        $return     = array(
            "result"                => "success",
            "response"            => $res,
        );
        logModuleCall('routeVlan',$serviceId,$return,$response);
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }

    static public function removeVlanrouting($serviceId, $vlanid) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $response           = Api::clearVlanConfiguration($vlanid);

        $vlan=Api::getVLAN($vlanid);
        $res['vlanid']=$vlanid;
        $res['vlan']='VLAN Tag #'.$vlan['vlanTag'].' '.$vlan['facilityCode'];
                 
        $return     = array(
            "result"                => "success",
            "response"            => $res,
        );
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }

    static public function updatePorts($serviceId, $action) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $enabled='true';
        if($action=='Disable')
            $enabled='false';
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        $response           = Api::updatePorts($assignedDeviceId,$enabled);

        $return     = array(
            "result"                => "success",
        );
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }

    static public function routeIP($serviceId, $subnetId) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $enabled='true';
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        $response           = Api::updatePorts($assignedDeviceId,$enabled,array($subnetId));

        //$vlan=Api::getVLAN($subnetId);
        $res['subnetid']=$subnetId;
        //$res['subnet']='VLAN Tag #'.$vlan['vlanTag'].' '.$vlan['facilityCode'];
        $res['subnet']='45.158.37.216/29';

        $return     = array(
            "result"                => "success",
            "response"            => $res,
        );

        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }

    static public function removeIprouting($serviceId, $subnetid) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        $enabled='true';
        $response           = Api::updatePorts($assignedDeviceId,$enabled,array());

        //$vlan=Api::getVLAN($subnetid);
        $res['subnetid']=$subnetid;
        $res['subnet']='45.158.37.216/29'; 
                 
        $return     = array(
            "result"                => "success",
            "response"            => $res,
        );
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }
    
    static public function removeAllRouting($serviceId) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $vlanList= Api::getVLANList();

        foreach ($vlanList as $key => $value) {
            if($value['portIds'])
            {
                $response = Api::clearVlanConfiguration($value['vlanId']);
                $res[]='<option value="'.$value['vlanId'].'">VLAN Tag #'.$value['vlanTag'].' '.$value['facilityCode'].'</option>';
            }
        }
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        $enabled='true';
        $response           = Api::updatePorts($assignedDeviceId,$enabled,array());
                         
        $return     = array(
            "result"                => "success",
            "response"            => $res,
        );
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
    }

    static public function requestIps($serviceId, $post) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $response           = Api::requestIps($post);

        $return     = array(
            "result"                => "success",
            "response"            => $response,
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
        
        if($hivelocityRecordType=='a-record')
        {
            $domain = Api::getDomain($hivelocityDomainId);
            $response = Api::addRecord($domain['name'], trim($hivelocityRecordType), $hivelocityRecordData);
        }
        else
        {
            $response           = Api::addRecord($hivelocityDomainId, $hivelocityRecordType, $hivelocityRecordData);
        }
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
            "ptr",
        ); 
        
        foreach ($recordTypes as $recordType) {
            if($recordType=='a-record')
            {
                $domain = Api::getDomain($hivelocityDomainId);
                $response = Api::getDnsRecordList($domain['name'], $recordType);

            }
            else{
                $response = Api::getDnsRecordList($hivelocityDomainId, $recordType);
            }
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

    static public function changePowerStatus($serviceId, $status) {
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        
        if($status=='POWER ON')
        {
            $response       = Api::bootDevice($assignedDeviceId);
        }
        elseif($status=='POWER OFF')
        {
            $response       = Api::shutdownDevice($assignedDeviceId);
        }
        
       
        
        $return     = array(
            "result"                => "success",
            "response"            => $response,
        );
        
        $returnJson = json_encode($return);
        echo $returnJson;
        die;
        
    }
}
