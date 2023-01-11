<?php
namespace HivelocityPricingTool\classes;
use Illuminate\Database\Capsule\Manager as Capsule;

class Addon {
    static public function config() {
        
        $serverGropupList   = Helpers::getServerGroupList();
        $serverGroupOptions = array();
        
        foreach($serverGropupList as $serverGroupData) {
            
            $serverGroupId      = $serverGroupData["id"];
            $serverGroupName    = $serverGroupData["name"];
            
            $serverGroupOptions[$serverGroupId] = $serverGroupName;
        }
        
        $productGropupList      = Helpers::getProductGroupList();
        $productGropupOptions   = array();
        
        foreach($productGropupList as $productGroupData) {
            
            $productGroupId     = $productGroupData["id"];
            $productGroupName   = $productGroupData["name"];
            
            $productGropupOptions[$productGroupId] = $productGroupName;
        }
        
        $configArray = array(
            
            "name"          => "Hivelocity Pricing Tool",
            "description"   => "A simple interface allowing you to quickly change pricing for all the products using Hivelocity as the provisioning module.",
            "version"       => "1.0.0",
            "author"        => "<a target='_blank' rel='noopener noreferrer' href='https://www.modulesgarden.com/'>ModulesGarden</a>",
            "language"      => "english",
            "fields"        => array(
                "priceNotification" => array (
                    "FriendlyName"      => "Price Change Notification", 
                    "Type"              => "yesno", 
                    "Size"              => "25",
                    "Description"       => "Check if you want to receive an email notification about the price change of Hivelocity products."
                ),
                "productGroup" => array (
                    "FriendlyName"      => "Product Group", 
                    "Type"              => "dropdown", 
                    "Options"           => $productGropupOptions,
                    "Size"              => "25",
                    "Description"       => "Product Group for auto created products."
                ),
                "serverGroup" => array (
                    "FriendlyName"      => "Server Group", 
                    "Type"              => "dropdown", 
                    "Options"           => $serverGroupOptions,
                    "Size"              => "25",
                    "Description"       => "Server Group for auto created products."
                ),
            )
        );
        
        return $configArray;
    }
    
    static public function output($params) {

        if($_GET['action']=='generateproducts')
        {
            //shell_exec('php '.\HivelocityPricingTool\classes\Cron::synchronizeProducts());
            echo '<h4>Product sync will take 5 to 10 minutes.</h4>'; 
            shell_exec('php /home/devwhmcs/public_html/modules/addons/HivelocityPricingTool/cron.php');
        }
        
        if(isset($_POST["hivelocityPricingToolAction"]) && !empty($_POST["hivelocityPricingToolAction"])) {
            $action = $_POST["hivelocityPricingToolAction"];
        } else {
            $action="";
        }
        
        $success    = false;
        $error      = false;
        
        try {
            if($action == "updatePricing") {
                
                foreach($_POST["productId"] as $index => $productId) {
                    $price      = $_POST["localPrice"][$index];
                    $currencyId = $_POST["currencyId"];
                    
                    Helpers::setProductPrice($productId, $price, $currencyId);
                }
                
                $success = true;
            }
        } catch(\Exception $e) {
            $error = $e->getMessage;
        }    
        
        $currencyList           = Helpers::getCurrencyList(); 
        
        $smartyVarsCurrencyList = array();
        
        foreach($currencyList as $currencyData) {
            
            $smartyVarsCurrencyList[$currencyData["id"]] = array(
                "code"      => $currencyData["code"],
                "suffix"    => $currencyData["suffix"]
            );
        }
        
        $productList            = Helpers::getProductList();
        
        $smartyVarsProductList = array();
            
        foreach($productList as $productData) {
            
            $productId          = $productData["id"];
            $serverConfig       = Helpers::getServerConfigByProductId($productId);
        
            $apiUrl             = $serverConfig["hostname"];
            $apiKey             = $serverConfig["accesshash"];
            
            Api::setApiDetails($apiUrl, $apiKey);
            
            $remoteProductId    = $productData["configoption1"];
            
            try {
                $remoteProductData  = Api::getProductDetails($remoteProductId);
            } catch ( \Exception $e) {
                continue;
            }
            
            $remoteProductPrice = 0;
            foreach($remoteProductData as $location => $data) {
                $remoteProductPrice = $data[0]["product_monthly_price"];
                break;
            }
            
            $usdRate            = Helpers::getCurrencyRate("USD");
            
            if($usdRate === false) {
                break;
            }
            
            $remoteProductPrice = $remoteProductPrice / $usdRate;
            
            $smartyVarsProductList[$productId] = array(
                "name" => $productData["name"]
            );
            
            foreach($currencyList as $currencyData) {
                
                $currencyId                     = $currencyData["id"];
                $productPrice                   = Helpers::getProductPrice($productId, $currencyId);
                
                $currencyRate                   = $currencyData["rate"];
                
                $remoteProductPriceConverted    = $remoteProductPrice * $currencyRate;
                
                $profit                         = $productPrice - $remoteProductPriceConverted;
                if($remoteProductPrice!=0)
                {
                    $profitPercentage           = ($profit / $remoteProductPrice) * 100;
                }
                
                $smartyVarsProductList[$productId]["remotePrice"][$currencyId]  = number_format($remoteProductPriceConverted, 2);
                $smartyVarsProductList[$productId]["localPrice"][$currencyId]   = number_format($productPrice, 2);
                $smartyVarsProductList[$productId]["profit"][$currencyId]       = number_format($profitPercentage, 2);
            }
        }
        
        $smarty                 = new \Smarty();
        
        $smarty->assign('productList',  $smartyVarsProductList);
        $smarty->assign('currencyList', $smartyVarsCurrencyList);
        $smarty->assign('success',      $success);
        $smarty->assign('error',        $error);
        
        $smarty->caching        = false;
        $smarty->compile_dir    = $GLOBALS['templates_compiledir'];
        
        $smarty->display(dirname(dirname(__FILE__)).'/templates/tpl/adminArea.tpl');
        
    }
}