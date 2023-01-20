<?php
namespace HivelocityPricingTool\classes;

class Api {
    static private $apiUrl;
    static private $apiKey;
    
    static public function setApiDetails($apiUrl, $apiKey) {
        
        $apiUrl = str_replace("DOT", ".", $apiUrl);
        
        self::$apiUrl   = "https://".$apiUrl."/api/v2/";
        self::$apiKey   = $apiKey;
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
                "User-Agent: PostmanRuntime/7.26.8",
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
                "Resource"  => $resource,
                "Method"    => $httpMethod,
                "Fields"    => !empty($postFields)?$postFields:"",
                "Json"      => !empty($postJson)?$postJson:"",
                "Query"     => !empty($postQuery)?$postQuery:"",
            );
            //logModuleCall("Hivelocity", $action, $request, "", $response);
        }
        //debug
        
        if ($cUrlError) {
            throw new \Exception($cUrlError);
        }
        
        $rawResponse = $response;
        if(!empty($response)) {
            $response = json_decode($response, true);
            
            if(json_last_error() != JSON_ERROR_NONE) {
                throw new \Exception("API response is invalid. ".$rawResponse);
            }
            
            if(isset($response["message"]) && isset($response["code"]) && $response["code"] != 201) {
                
                if(is_array($response["message"])) {
                    $message = implode(" ", $response["message"]);
                } else {
                    $message = $response["message"];
                }
                
                throw new \Exception($message);
            }
            
            if(isset($response["description"]) && isset($response["code"]) && $response["code"] > 201) {
                
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
            throw new \Exception("API response is invalid.");
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
        
        $resource = "/product/$productId/options?groupBy=upgrade";
        $response = self::sendRequest($resource);
        
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
    
    static public function configureDeployment($deploymentId, $productId, $locationId, $osId, $panelId, $hostName, $billingPeriod) {
        
        $resource = "/deploy/$deploymentId";
        
        $postFields = array(
            "locationCode"      => $locationId,
            "billingPeriod"     => $billingPeriod,
            "operatingSystem"   => $osId,
            "hostnames"         => array($hostName),
            "productId"         => $productId,
        );
        
        if(!empty($panelId)) {
            $postFields["options"] = array($panelId);
        }
        
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
    
    static public function getServiceList($orderId) {
        
        $resource = "/service/?orderId=$orderId";
        
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
    
    static public function cancelDevice($deviceId) {
        
        $resource   = "/cancellation/cancellation";
        
        $postFields = array(
            "deviceId" => $deviceId,
        );
        
        $response   = self::sendRequest($resource, "POST", $postFields);
        
        return $response;
    }
    
    static public function getGraph($deviceId, $period = "day", $start = null, $end = null) {
        
        $resource   = "/bandwidth/device/$deviceId/image";
        
        $postFields = array(
            "period"    => $period,
            "start"     => $start,
            "end"       => $end,
            "interface" => "eth0",
        );
        
        $response   = self::sendRequest($resource, "POST", $postFields, true);
        
        return $response;
    }
    
    static public function getBandwidthDetails($deviceId, $period = "day", $start = null, $end = null) {
        
        $resource   = "/bandwidth/device/$deviceId";
        
        $postFields = array(
            "period"    => $period,
            "start"     => $start,
            "end"       => $end,
            "interface" => "eth0",
        );
        
        $response   = self::sendRequest($resource, "POST", $postFields, true);
        
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
}
