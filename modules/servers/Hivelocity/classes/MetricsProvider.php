<?php
namespace Hivelocity\classes;
use Illuminate\Database\Capsule\Manager as Capsule;
use WHMCS\UsageBilling\Contracts\Metrics\MetricInterface;
use WHMCS\UsageBilling\Contracts\Metrics\ProviderInterface;
use WHMCS\UsageBilling\Metrics\Metric;
use WHMCS\UsageBilling\Metrics\Units\FloatingPoint;
use WHMCS\UsageBilling\Metrics\Usage;

class Bits extends FloatingPoint {
    public function __construct($name = 'Bits', $singlePerUnitName = 'Bit', $pluralPerUnitName = 'Bits', $prefix = null, $suffix = 'b') {
        parent::__construct($name, $singlePerUnitName, $pluralPerUnitName, $prefix, $suffix);
    }
}

class BitsPerSecond extends FloatingPoint {
    public function __construct($name = 'BitsPerSecond', $singlePerUnitName = 'Bit Per Second', $pluralPerUnitName = 'Bits Per Second', $prefix = null, $suffix = 'b/s') {
        parent::__construct($name, $singlePerUnitName, $pluralPerUnitName, $prefix, $suffix);
    }
}

class MetricsProvider implements ProviderInterface {
    
    private $moduleParams = [];
    public function __construct($params) {
        
        $this->moduleParams = $params;
    }

    public function metrics() {
        return [
            new Metric(
                'xferIn',
                'Xfer In',
                MetricInterface::TYPE_PERIOD_MONTH,
                new Bits()
            ),
            new Metric(
                'xferOut',
                'Xfer Out',
                MetricInterface::TYPE_PERIOD_MONTH,
                new Bits()
            ),
            new Metric(
                '95In',
                '95% In',
                MetricInterface::TYPE_PERIOD_MONTH,
                new BitsPerSecond()
            ),
             new Metric(
                '95Out',
                '95% Out',
                MetricInterface::TYPE_PERIOD_MONTH,
                new BitsPerSecond()
            ),
        ];
    }

    public function usage() {
        
        $serverId       = $this->moduleParams["serverid"];
        $serviceIdList  = Helpers::getServiceIdList($serverId);
        
        $usage          = array();
        
        foreach($serviceIdList as $serviceId) {
            
            $domain         = Helpers::getServiceDomain($serviceId);
            $usage[$domain] = $this->tenantUsage($domain);
        }
        
        return $usage;
    }
    
    public function tenantUsage($domain) {
        
        set_time_limit(60);
        
        $apiUrl             = $this->moduleParams["serverhostname"];
        $apiKey             = $this->moduleParams["serveraccesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $serviceId          = Helpers::getServiceIdByDomain($domain);
        
        $assignedDeviceId   = Helpers::getAssignedDeviceId($serviceId);
        $hivelocityOrderId            = Helpers::getHivelocityOrderCorrelation($serviceId);
        
        if($assignedDeviceId === false && $hivelocityOrderId !== false) {
            
            try {
                $orderDetails       = Api::getOrderDetails($hivelocityOrderId);
                $orderStatus        = $orderDetails["status"];
            } catch (\Exception $e) {
                $orderStatus        = "unknown";
            }
            
            if($orderStatus == "complete") {
                
                $remoteServiceList = Api::getServiceList($hivelocityOrderId);
                
                foreach($remoteServiceList as $remoteService) {
                    
                    if($remoteService["orderId"] == $hivelocityOrderId) {
                        
                        $remoteServiceId    = $remoteService["serviceId"];
                        
                        Helpers::saveHivelocityServiceCorrelation($serviceId, $remoteServiceId);
                        
                        $deviceId           = $remoteService["serviceDevices"][0]["id"];
                        Helpers::assignDevice($serviceId, $deviceId);
                        $assignedDeviceId   = $deviceId;
                        
                        break;
                    }
                }
            }
        }
        
        if($assignedDeviceId === false) {
            return array();
        }
        
        try {
            $bnandwidthDetails = Api::getBandwidthDetails($assignedDeviceId, "month");
        } catch (\Exception $e) {
            return array();
        }
        
        return $this->wrapData($bnandwidthDetails);
    }

    private function wrapData($data) {
        
        $wrapped        = [];
        
        $keyDictionary  = array(
            "xferIn"    => "In Xfer",
            "xferOut"   => "Out Xfer",
            "95In"      => "In 95th",
            "95Out"     => "Out 95th",
        );
        
        foreach ($this->metrics() as $metric) {
            
            $key = $keyDictionary[$metric->systemName()];
            
            if ($data[0]["metadata"]["totals"][$key]) {
                
                $value  = $data[0]["metadata"]["totals"][$key];
                $usage  = new Usage($value);
                $metric = $metric->withUsage($usage);
            }
            
            $wrapped[] = $metric;
        }
        
        return $wrapped;
    }
}
