<?php
namespace Hivelocity\classes;

class Api {
    static private $apiUrl;
    static private $apiKey;
    
    static public function setApiDetails($apiUrl, $apiKey) {
        
        $apiUrl = str_replace("DOT", ".", $apiUrl);
        
        self::$apiUrl   = "https://".$apiUrl."/api/v2";
        self::$apiKey   = $apiKey;
    }

    static public function GetIonCubeLoaderVersion() {
        
        ob_start();
        phpinfo(INFO_GENERAL);
        $aux = str_replace('&nbsp;', ' ', ob_get_clean());
        if($aux !== false)
        {
            $pos = mb_stripos($aux, 'ionCube PHP Loader');
            if($pos !== false)
            {
                $aux = mb_substr($aux, $pos + 18);
                $aux = mb_substr($aux, mb_stripos($aux, ' v') + 2);

                $version = '';
                $c = 0;
                $char = mb_substr($aux, $c++, 1);
                while(mb_strpos('0123456789.', $char) !== false)
                {
                    $version .= $char;
                    $char = mb_substr($aux, $c++, 1);
                }

                return $version;
            }
        }

        return false;
    }

    static public function sendRequest($resource, $httpMethod = 'GET', $postFields = array(), $postInQuery = false) {
        
        $apiKey = self::$apiKey;
        $url    = self::$apiUrl.$resource;
        
        $ch = curl_init();
        
        if(!empty($postFields)) {
            if($httpMethod == "POST" && $postInQuery) {
                $postQuery  = http_build_query($postFields);
                $url        = $url."?".$postQuery;
            } else {
                $postJson   = json_encode($postFields); 
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postJson);
            }
        }
        
        $user_agent = 'PHP-Curl-Class/4.10.0(+https://github.com/php-curl-class/php-curl-class)';
        $user_agent .= ' PHP/' . PHP_VERSION;
        $curl_version = curl_version();
        $user_agent .= ' curl/' . $curl_version['version'];
        $modulev=Addon::getMetaData();
        $user_agent .= ' WHMCSModule/'.$modulev['APIVersion'];
        $ioncubev = self::GetIonCubeLoaderVersion();
        $user_agent .= ' ioncube/'.$ioncubev;
        $user_agent .= ' ServerIP/'.$_SERVER['SERVER_ADDR'];

        curl_setopt($ch, CURLOPT_URL,               $url);
        curl_setopt($ch, CURLOPT_FAILONERROR,       false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,    0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,    0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,    1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,     $httpMethod);
        //curl_setopt($ch, CURLOPT_COOKIESESSION,     true);
        //curl_setopt($ch, CURLOPT_COOKIEJAR,         __DIR__."/q/jar");
        //curl_setopt($ch, CURLOPT_COOKIEFILE,        __DIR__."/q/file");
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "User-Agent: ".$user_agent,
                "Accept: */*",
                "Accept-Encoding: ''",
                "X-API-KEY: $apiKey"
        ));
        
        $response   = curl_exec($ch);
        $cUrlError  = curl_error($ch);
        curl_close($ch);
        
        //debug
        if(1) {
            if ($cUrlError) {
                $response = $cUrlError;
            }
            
            $action     = "Hivelocity API Call";
            $request    = array(
                "API URL"   => self::$apiUrl,
                "Resource"  => $resource,
                "Method"    => $httpMethod,
                "Fields"    => !empty($postFields)?$postFields:"",
                "Json"      => !empty($postJson)?$postJson:"",
                "Query"     => !empty($postQuery)?$postQuery:"",
            );

            /*if($resource=='/billing-info/')
            {
                $response='{"response":"success"}';
            }*/

            logModuleCall("Hivelocity", $url, $request, "", $response);
        }
        //debug
        
        if ($cUrlError) {
            throw new \Exception($cUrlError);
        }
        
        $rawResponse = $response;
        if(!empty($response)) {
            $response = json_decode($response, true);
            
            if(json_last_error() != JSON_ERROR_NONE) {
                throw new \Exception("API response is invalid.");
            }
            
            if(isset($response["message"]) && isset($response["code"]) && $response["code"] > 202) {
                
                if(is_array($response["message"])) {
                    $message = implode(" ", $response["message"]);
                } else {
                    $message = $response["message"];
                }
                
                throw new \Exception($message);
            }
            
            if(isset($response["description"]) && isset($response["code"]) && $response["code"] > 202) {
                
                if(is_array($response["description"])) {
                    $message = implode(" ", $response["description"]);
                } else {
                    $message = $response["description"];
                }
                
                throw new \Exception($message);
            }
            
            if(isset($response["schema_errors"])) {
                $fullMessage = "";
                foreach($response["schema_errors"] as $field => $error) {
                    
                    foreach($error as $msg) {
                        if(is_array($msg)) {
                            $message = implode(" ", $msg);
                        } else {
                            $message = $msg;
                        }
                        $message = $field.": ".$message;
                    }
                    $fullMessage .= $message." ";
                }
                throw new \Exception($fullMessage);
            }
            
            if(isset($response["errors"])) {
                $fullMessage = "";
                foreach($response["errors"] as $field => $error) {
                    if(is_array($error)) {
                        $message = $field.": ".implode(" ", $error);
                        $fullMessage .= $message." ";
                    } else {
                        $message = $error;
                        $fullMessage .= $message." ";
                    }
                    
                }
                throw new \Exception($fullMessage);
            }
            
        } else {
            //throw new \Exception("API response is invalid.");
        }
        return $response;
    }
    
    static public function getProductList() {
        
        $resource = "/inventory/product";
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function getProductDetails($productId) {
        
        $resource = "/inventory/product/$productId";
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function getProductOptions($productId) {
        
        $resource = "/product/$productId/options";
        $response = self::sendRequest($resource);
        
        $resource = "/product/$productId/options?groupBy=upgrade";
        $response = self::sendRequest($resource);
        
        return $response;
    }

    static public function getBackup($productId,$optionId) {
        
        $resource = "/bare-metal-devices/";
        
        $postFields = array(
            "period" => "hourly",
            "productId" => $productId,
            "option_ids" => $optionId,
        );
        
        $response = self::sendRequest($resource, "GET", $postFields, true);
        
        return $response;
    }
    
    static public function getProductOS($productId) {
        
        $resource = "/product/$productId/operating-systems";
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function getBillingInfoList() {
        
        $resource = "/billing-info/";
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function createDeployment($deploymentName) {
        
        $resource = "/deploy/";
        
        $postFields = array(
            "deploymentName" => $deploymentName,
        );
        
        $response = self::sendRequest($resource, "POST", $postFields, true);
        
        return $response;
    }
    
    static public function getDeploymentList() {
        
        $resource = "/deploy/";
        
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function getDeploymentDetails($deploymentId) {
        
        $resource = "/deploy/$deploymentId";
        
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function configureDeployment($deploymentId, $productId, $locationId, $osId, $options, $hostName, $billingPeriod) {
        
        $resource = "/deploy/$deploymentId";
        
        $postFields = array(
            "locationCode"      => $locationId,
            "billingPeriod"     => $billingPeriod,
            "operatingSystem"   => $osId,
            "hostnames"         => array($hostName),
            "productId"         => $productId,
            "options"           => $options,
            "quantity"           => '1',
        );
        /*
        if(!empty($panelId)) {
            $postFields["options"] = array($panelId);
        }
        */
        $response = self::sendRequest($resource, "PUT", $postFields);
        
        return $response;
    }
    
    static public function executeDeployment($deploymentId, $billingInfoId) {
        
        $resource   = "/deploy/$deploymentId";
        
        $postFields = array(
            "billingInfo" => $billingInfoId,
        );
        
        $response   = self::sendRequest($resource, "POST", $postFields);
        
        return $response;
    }
    
    static public function getInvoiceList() {
        
        $resource = "/invoice/";
        
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function getOrderList() {
        
        $resource = "/order/";
        
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function getOrderDetails($orderId) {
        
        $resource = "/order/$orderId";
        
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function getServiceList($orderId) {
        
        $resource = "/service/?orderId=$orderId";
        
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function getServiceDetails($serviceId) {
        
        $resource = "/service/$serviceId";
        
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function getDeviceList() {
        
        $resource = "/device/";
        
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function getDeviceDetails($deviceId) {
        
        $resource = "/device/$deviceId";
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function getInitialPassword($deviceId) {
        
        $resource = "/device/$deviceId/initial-creds";
        $response = self::sendRequest($resource);
        
        return $response;
    }
        
    static public function getIpAssigment($deviceId) {
        
        $resource = "/device/$deviceId/ip_assignment";
        $response = self::sendRequest($resource);
        
        return $response;
    }

    static public function getIpAssigments($deviceId) {
        
        $resource = "/device/$deviceId/ips";
        $response = self::sendRequest($resource);
        
        return $response;
    }
    
    static public function cancelDevice($deviceId, $serviceId) {
        
        $resource   = "/cancellation/cancellation";
        
        $postFields = array(
            "deviceId"  => $deviceId,
            "serviceId" => $serviceId,
            "reason"    => "I am a reseller and my customer cancelled",
        );
        
        $response   = self::sendRequest($resource, "POST", $postFields);
        
        return $response;
    }
    
    static public function getGraph($deviceId, $period = "day", $start = null, $end = null) {
        $queryParams = "period=$period&interface=eth1";

        if ($start !== null) {
            $queryParams .= "&start=$start";
        }

        if ($end !== null) {
            $queryParams .= "&end=$end";
        }
        
        $resource   = "/bandwidth/device/$deviceId/image?$queryParams";
        
        $postFields = array();
        
        $response   = self::sendRequest($resource, "POST", $postFields, true);
        
        return $response;
    }
    
    static public function getIpmiData($deviceId) {
        
        $resource   = "/device/$deviceId/ipmi";
        
        $response   = self::sendRequest($resource, "GET");
        
        return $response;
    }
    
    static public function getBandwidthDetails($deviceId, $period = "day", $start = null, $end = null) {
        
        $resource   = "/bandwidth/device/$deviceId";
        
        $postFields = array(
            "period"    => $period,
            "start"     => $start,
            "end"       => $end,
            "step"      => 43200,
            "interface" => "eth0",
        );
        
        $response   = self::sendRequest($resource, "POST", $postFields, true);
        
        return $response;
    }

    static public function getDevicePowerStatus($deviceId) {
        
        $resource   = "/device/$deviceId/power";
        
        $response   = self::sendRequest($resource, "GET");
        
        return $response;
    }
    
    static public function executePowerAction($deviceId, $powerAction) {
        
        $resource   = "/device/$deviceId/power";
        
        $postFields = array(
            "action" => $powerAction,
        );
        
        $response   = self::sendRequest($resource, "POST", $postFields, true);
        
        return $response;
    }
    
    static public function bootDevice($deviceId) {
        
        return self::executePowerAction($deviceId, "boot");
    }
    
    static public function rebootDevice($deviceId) {
        
        return self::executePowerAction($deviceId, "reboot");
    }
    
    static public function shutdownDevice($deviceId) {
        
        return self::executePowerAction($deviceId, "shutdown");
    }
    
    static public function reloadDevice($deviceId, $osId) {
        
        $resource   = "/device/$deviceId/reload";
        
        $postFields = array(
            "operatingSystemId"    => $osId,
        );
        
        $response   = self::sendRequest($resource, "POST", $postFields);
        
        return $response;
    }
    
    static public function getDomainList() {
        
        $resource   = "/domains/";
        
        $response   = self::sendRequest($resource, "GET");
        
        return $response;
    }

    static public function getDomain($domainId) {
        
        $resource   = "/domains/$domainId";
        
        $response   = self::sendRequest($resource, "GET");
        
        return $response;
    }
    
    static public function addDomain($domainName) {
        
        $resource   = "/domains/";
        
        $postFields = array(
            "name"    => $domainName,
        );
        
        $response   = self::sendRequest($resource, "POST", $postFields);
        
        return $response;
    }
    
    static public function removeDomain($domainId) {
        
        $resource   = "/domains/$domainId";
        $response   = self::sendRequest($resource, "DELETE");
        
        return $response;
    }
    
    static public function addRecord($domainId, $recordType, $recordData) {

        $resource   = "/domains/$domainId/$recordType";
        $response   = self::sendRequest($resource, "POST", $recordData);
        
        if($recordType == "mx-record") {
            $response["type"] = "MX";
        }
        return $response;
    }
    
    static public function editRecord($domainId, $recordType, $recordId, $recordData) {
        
        $resource   = "/domains/$domainId/$recordType/$recordId";
        $response   = self::sendRequest($resource, "PUT", $recordData);
        
        if($recordType == "mx-record") {
            $response["type"] = "MX";
        }
        
        return $response;
    }
    
    static public function removeRecord($domainId, $recordType, $recordId) {
        
        $resource   = "/domains/$domainId/$recordType/$recordId";
        $response   = self::sendRequest($resource, "DELETE");
        
        return $response;
    }
    
    static public function getDnsRecordList($domainId, $recordType) {
        
        if($recordType == "ptr") {
            $resource   = "/domains/ptr";
        } else {
            $resource   = "/domains/$domainId/$recordType";
        }
        $response   = self::sendRequest($resource, "GET");
        
        if($recordType == "mx-record") {
            
            foreach($response as $key => $recordData) {
                $response[$key]["type"] = "MX";
            }
        }
        return $response;
    }
    
    static public function allowIp($deviceId, $ip) {
        
        $resource   = "/device/$deviceId/ipmi/whitelist/";
        
        $postFields = array(
            "custIp"    => $ip,
        );
        
        $response   = self::sendRequest($resource, "POST", $postFields);
        
        return $response;
    }
    
    static public function parseProductList($productList) {
        
        $productListParsed = array();
        
        foreach($productList as $location => $list) {
            
            
            foreach($list as $productDetails) {
                
                $productId = $productDetails["product_id"];
                
                foreach($productDetails as $key => $value) {
                    
                    if($key == "monthly_location_premium") {
                        continue;
                    }
                    $productListParsed[$productId][$key] = $value;
                }
                $productListParsed[$productId]["locations"][$location]["price"] = $productDetails["monthly_location_premium"];
                $productListParsed[$productId]["locations"][$location]["stock"] = $productDetails["stock"];
            }
        }
        return $productListParsed;
    }

    static public function customapi($data) {
              
        $resource   = "/bare-metal-devices/";
                
        $response   = self::sendRequest($resource, "POST", $data);
        
        return $response;
    }

    static public function createVLAN($type, $facilityCode) {
        
        $resource   = "/vlan/";
        
        $postFields = array(
            "facilityCode" => $facilityCode,
            "type" => $type,
        );
        
        $response   = self::sendRequest($resource, "POST", $postFields);
        
        return $response;
    }

    static public function getVLANList() {
        
        $resource = "/vlan/";
        $response = self::sendRequest($resource);
        
        return $response;
    }

    static public function getVLAN($vlanId) {
        
        $resource = "/vlan/$vlanId";
        $response = self::sendRequest($resource);
        
        return $response;
    }

    static public function modifyVLAN($data,$vlanId) {
        
        $resource = "/vlan/$vlanId";
        $response = self::sendRequest($resource, "PUT", $data);
        return $response;
    }

    static public function removeVLAN($vlanId) {
        
        $resource   = "/vlan/$vlanId";
        $response   = self::sendRequest($resource, "DELETE");
        
        return $response;
    }

    static public function clearVlanConfiguration($vlanId) {
        
        $resource   = "/vlan/$vlanId/clear";
        $response   = self::sendRequest($resource, "POST");
        
        return $response;
    }

    static public function getLocations() {
        
        $resource = "/inventory/locations";
        $response = self::sendRequest($resource);
        
        return $response;
    }

    static public function getPorts($deviceId) {
        
        $resource = "/device/$deviceId/ports";
        $response = self::sendRequest($resource);
        
        return $response;
    }

    static public function updatePorts($deviceId,$enabled,$ips=array()) {
        
        $resource = "/device/$deviceId/ports";

        $ports= self::getPorts($deviceId);
        foreach ($ports as $key => $value) {
            if($value['type']=='Bond Interface')
                $portarr=$value['portId'];
        }

        $data['ports'][]=array('portId' => $portarr,'enabled' => $enabled,'ipAssignments'=>$ips);

        $response = self::sendRequest($resource, "PUT", $data);
        
        return $response;
    }

    static public function Unbond($deviceId) {
        
        $resource   = "/device/$deviceId/ports/bond";
        $response   = self::sendRequest($resource, "DELETE");
        
        return $response;
    }

    static public function Bond($deviceId) {
        
        $resource   = "/device/$deviceId/ports/bond";
        $response   = self::sendRequest($resource, "POST");
        
        return $response;
    }

    static public function getAvailableIps() {
        
        $resource = "/ip/";
        
        $response = self::sendRequest($resource);
        
        return $response;
    }

    static public function getAllEvents($deviceId) {
        
        $resource = "/network/status/$deviceId";
        //$resource = "/network/status";            not getting response 
        
        $response = self::sendRequest($resource);
        
        return $response;
    }

    static public function requestIps($post) {
        
        $resource   = "/ip";
        
        $postFields = array(
            //"device_id" => $post['device_id'],
            "prefixLength" => $post['number_requested'],
            "purpose" => $post['purpose'],
        );
        
        $response   = self::sendRequest($resource, "POST", $postFields);
        
        return $response;
    }

    static public function getAllSSHkeys() {
        
        $resource = "/ssh_key";
        $response = self::sendRequest($resource);
        return $response;
    }
}
