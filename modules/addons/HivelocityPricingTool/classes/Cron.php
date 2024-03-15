<?php
namespace HivelocityPricingTool\classes;
use Illuminate\Database\Capsule\Manager as Capsule;

class Cron {
    static public function priceChangeNotify() {
        
        $productList           = Helpers::getProductList();

        $addonConfig        = Helpers::getAdonConfig();
        $serverGroupId      = $addonConfig["serverGroup"];
        $productGroupId     = $addonConfig["productGroup"];
        $debugMode          = $addonConfig["debugMode"];

        $serverConfig       = Helpers::getServerConfigByServerGroupId($serverGroupId);
        
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);

        $remoteProductListRaw  = Api::getProductList();
        $remoteProductList     = array();

        foreach($remoteProductListRaw as $location => $list) {

            foreach($list as $remoteProductData) {
                $remoteProductId    = $remoteProductData["product_id"];
                if(isset($remoteProductList[$remoteProductId])) {
                    if($remoteProductData["stock"] != "unavailable") {
                        $remoteProductList[$remoteProductId] = $remoteProductData;
                    }
                } else {
                    $remoteProductList[$remoteProductId] = $remoteProductData;
                }
            }
        }
        
        if ($debugMode === "on") {
            logModuleCall('Hivelocity','priceChangeNotify','remoteProductList',$remoteProductList);
        }

        foreach($productList as $productData) {
            set_time_limit(60);
            $productId                  = $productData["id"];
            $remoteProductPrice         = 0;
            
            if (array_key_exists($remoteProductId, $remoteProductList)) {
                $remoteProductId            = $productData["configoption1"];
                $remoteProductPrice         = $remoteProductList[$remoteProductId]["product_monthly_price"];
            } else {
                continue;
            }

            $savedRemoteProductPrice    = Helpers::getHivelocityProductPrice($remoteProductId);
            if($savedRemoteProductPrice === false) {
                Helpers::saveHivelocityProductPrice($remoteProductId, $remoteProductPrice);
            } elseif($savedRemoteProductPrice != $remoteProductPrice && $remoteProductPrice != 0) {
                Helpers::saveHivelocityProductPrice($remoteProductId, $remoteProductPrice);
                if (Helpers::isNotificationEnabled()) {
                    $command = 'SendAdminEmail';

                    $postData = array(
                        'messagename' => 'Hivelocity Product Price Change',
                        'mergefields' => array('hivelocityProductId' => $remoteProductId, 'oldPrice' => number_format($savedRemoteProductPrice, 2)." USD", 'newPrice' => number_format($remoteProductPrice, 2)." USD"),
                    );
                    
                    $results = localAPI($command, $postData);
                }
            }
        }
    }
    
    static public function synchronizeProducts() {
        
        $addonConfig        = Helpers::getAdonConfig();
        $serverGroupId      = $addonConfig["serverGroup"];
        $productGroupId     = $addonConfig["productGroup"];
        $debugMode          = $addonConfig["debugMode"];
        
        Helpers::updateProductGroupConfig($productGroupId);
        Helpers::updateServerGroupConfig($serverGroupId);

        $serverConfig       = Helpers::getServerConfigByServerGroupId($serverGroupId);
        
        $apiUrl             = $serverConfig["hostname"];
        $apiKey             = $serverConfig["accesshash"];
        
        Api::setApiDetails($apiUrl, $apiKey);
        
        $remoteProductListRaw  = Api::getProductList();
        $remoteProductList     = array();

        foreach($remoteProductListRaw as $location => $list) {
            foreach($list as $remoteProductData) {
                $remoteProductId    = $remoteProductData["product_id"];
                if(isset($remoteProductList[$remoteProductId])) {
                    if($remoteProductData["stock"] != "unavailable") {
                        $remoteProductList[$remoteProductId] = $remoteProductData;
                    }
                } else {
                    $remoteProductList[$remoteProductId] = $remoteProductData;
                }
            }
        }

        if ($debugMode === "on") {
            logModuleCall('Hivelocity','synchronizeProducts','remoteProductList',$remoteProductList);
        }
        
        $currencyList       = Helpers::getCurrencyList();
        foreach($currencyList as $currency) {
            $currencyId     = $currency["id"];
        }
        
        $processedProducts  = array(); 
        
        $billingInfoList    = Api::getBillingInfoList();
        $billingId          = $billingInfoList[0]["id"];

        if ($debugMode === "on") {
            logModuleCall('Hivelocity','synchronizeProducts','billingId',$billingId);
        }

        foreach ($remoteProductList as $remoteProductId => $remoteProductData) {
            set_time_limit(120);
            $localProductId     = Helpers::getProductIdByRemoteProductId($remoteProductId);

            if($localProductId == false && $remoteProductData["stock"] != "unavailable") {
                //create product
                $price              = floatval($remoteProductData["product_monthly_price"]);
            
                $usdRate            = Helpers::getCurrencyRate("USD");
                $basePrice          = $price / $usdRate;

                $currencyList       = Helpers::getCurrencyList();
                $pricing            = array();
                
                foreach($currencyList as $currency) {
                    $currencyId     = $currency["id"];
                    $currencyRate   = $currency["rate"];
                    $priceConverted = $basePrice * $currencyRate;
                    $pricing[$currencyId]["monthly"] = $priceConverted;
                }

                $desc='';
                if($remoteProductData["product_bandwidth"]) {
                    $desc .="Bandwidth : ".$remoteProductData["product_bandwidth"];
                }

                if($remoteProductData["product_cpu"]) {
                    $desc .="<br>CPU : ".$remoteProductData["product_cpu"];
                }

                if($remoteProductData["product_memory"]) {
                    $desc .="<br>Memory : ".$remoteProductData["product_memory"];
                }

                if($remoteProductData["product_drive"]) {
                    $desc .="<br>Drive : ".$remoteProductData["product_drive"];
                }

                $result             = WhmcsApi::AddProduct([
                    "name"              => $remoteProductData["product_id"]." - ".$remoteProductData["product_cpu"]." - ".$remoteProductData["product_memory"]." - ".$remoteProductData["product_drive"],
                    "gid"               => $productGroupId,
                    "type"              => "server",
                    "paytype"           => "recurring",
                    "autosetup"         => "payment",
                    "pricing"           => $pricing,
                    "servergroupid"     => $serverGroupId,
                    "module"            => "Hivelocity",
                    "configoption1"     => $remoteProductId,
                    "configoption2"     => $billingId,
                    "description"       => $desc,
                ]);

                $localProductId     = $result["pid"];
                logModuleCall('Hivelocity','synchronizeProducts','localProductId',$localProductId);
                Helpers::addProductCustomField($localProductId);
                Helpers::createConfigOptions($localProductId, $remoteProductId);
                $processedProducts[]    = $localProductId;
            } elseif($localProductId != false && $remoteProductData["stock"] != "unavailable") {
                //update product
                logModuleCall('Hivelocity','synchronizeProducts','localProductId',$localProductId);
                Helpers::createConfigOptions($localProductId, $remoteProductId);
                $processedProducts[]    = $localProductId;
            }
        }

        if ($debugMode === "on") {
            logModuleCall('Hivelocity','synchronizeProducts','processedProducts',$processedProducts);
        }
        
        $localProductList   = Helpers::getProductList();
        foreach($localProductList as $localProductData) {
            $localProductId = $localProductData["id"];
            if(in_array($localProductId, $processedProducts)) {
                Helpers::unhideProduct($localProductId);
            } else {
                Helpers::hideProduct($localProductId);
                if ($debugMode === "on") {
                    logModuleCall('Hivelocity','synchronizeProducts','hideProduct',$localProductId);
                }
            }
        }
    }
}
