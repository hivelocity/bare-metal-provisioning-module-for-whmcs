<?php

namespace HivelocityPricingTool\classes;

class WhmcsApi {
    
    static public function __callStatic($name, $args) {
        
        $command  = $name;
        $postData = $args[0];
        
        $results  = localAPI($command, $postData);
        
        if(isset($results["result"]) && $results["result"] == "error" || isset($results["status"]) && $results["status"] == "error") {
            
            Helpers::debugLog("WhmcsApi error", $results["message"]);
            throw new \Exception($results["message"]);
        }
        
        return $results;
    }
}
