<?php
namespace Hivelocity\classes;
use Illuminate\Database\Capsule\Manager as Capsule;

class Graph {
    
    static public function getGraph() {
        
        $loggedUserId       = $_SESSION["uid"];
        
        $serviceId          = $_GET["hivelocityServiceId"];
        $period             = $_GET["hivelocityPeriod"];
        $customPeriod       = $_GET["hivelocityCustomPeriod"];
        
        $serviceUserId      = Helpers::getUserIdByServiceId($serviceId);
        
        if(empty($loggedUserId) || $loggedUserId != $serviceUserId) {
            die;
        }
        
        $productId          = Helpers::getProductIdByServiceId($serviceId);
        
        $serverConfig       = Helpers::getServerConfigByProductId($productId);
        
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];

        
        $assignedDevice     = Helpers::getAssignedDeviceId($serviceId);
        
        $temp = explode("-",$customPeriod);
        
        $startDateString    = trim($temp[0]);
        $EndDateString      = trim($temp[1]);  
        
        $startDate          = new \DateTime($startDateString);
        $endDate            = new \DateTime($EndDateString);
        
        $endDate->modify('+1 day');
        
        $startTimestamp     = $startDate->getTimestamp();
        $endTimestamp       = $endDate->getTimestamp();
        
        Api::setApiDetails($apiUrl, $apiKey);

        $response = Api::getGraph($assignedDevice, $period, $startTimestamp, $endTimestamp);

        echo json_encode($response);

        exit;
    }
}