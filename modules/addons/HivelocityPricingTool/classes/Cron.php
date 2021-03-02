<?php
namespace HivelocityPricingTool\classes;
use Illuminate\Database\Capsule\Manager as Capsule;

class Cron {
    static public function priceChangeNotify() {
        
        $productList           = Helpers::getProductList();
        
        foreach($productList as $productData) {
            
            set_time_limit(60);
            
            $productId                  = $productData["id"];
            $serverConfig               = Helpers::getServerConfigByProductId($productId);
        
            $apiUrl                     = $serverConfig["hostname"];
            $apiKey                     = $serverConfig["accesshash"];
            
            Api::setApiDetails($apiUrl, $apiKey);
            
            try {
                $remoteProductId            = $productData["configoption1"];
                $remoteProductData          = Api::getProductDetails($remoteProductId);
            } catch (\Exception $e) {
                continue;
            }
            
            $remoteProductPrice         = 0;
            foreach($remoteProductData as $location => $data) {
                $remoteProductPrice = $data[0]["product_monthly_price"];
                break;
            }
            
            $savedRemoteProductPrice    = Helpers::getHivelocityProductPrice($remoteProductId);
            
            if($savedRemoteProductPrice === false) {
                
                Helpers::saveHivelocityProductPrice($remoteProductId, $remoteProductPrice);
                
            } elseif($savedRemoteProductPrice != $remoteProductPrice) {
                
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
}
