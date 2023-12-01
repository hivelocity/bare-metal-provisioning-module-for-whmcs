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
            "version"       => "1.1",
            "author"        => "<a target='_blank' rel='noopener noreferrer' href=''>Hivelocity</a>",
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

        $crondisable='';

        $output = shell_exec('crontab -l');
        if($output)
        {
            if(!str_contains($output, '/HivelocityPricingTool/cron.php') && !substr_count($output, "HivelocityPricingTool") > 1)
            {
                $crondisable='It seems cron is not setup yet.Please set the cron first.';
            }
        }

        $disabled='';
        $disabledmsg='';

        $q=mysql_query("SELECT value FROM mod_hivelocity_cron WHERE value='RunFiveMinCron'");
        if(mysql_num_rows($q))
        {
            $disabled='disabled';
            $disabledmsg='Product sync is in progress it may take 5-10 min.Please be patient. Make sure that cron is setup for every 5 minute.';
        }
        else
        {
            $disabled='';
            $disabledmsg='';
        }

        if($_GET['action']=='generateproducts')
        {
            mysql_query("DELETE FROM mod_hivelocity_cron WHERE value='RunFiveMinCron'");
            insert_query("mod_hivelocity_cron",array("value"=>'RunFiveMinCron',"created_at"=>date('Y-m-d h:i:s')));
            $disabled='disabled';
            $disabledmsg='Product sync is in progress it may take 5-10 min.Please be patient. Make sure that cron is setup for every 5 minute.';
        }
        
        if(isset($_POST["hivelocityPricingToolAction"]) && !empty($_POST["hivelocityPricingToolAction"])) {
            $action = $_POST["hivelocityPricingToolAction"];
        } else {
            $action="";
        }
        
        $success    = false;
        $error      = false;
        $productList            = Helpers::getProductList();
        try {
            if($action == "updatePricing") { 

                if($_POST["globalchange"]=='true'){

                    unset($_POST['DataTables_Table_0_length']);
                    $globalprofit=(float)$_POST["globalprofit"];
                    foreach($productList as $productData) {
                        $remoteProductPrice    = Helpers::getHivelocityProductPrice($productData["configoption1"]);
                        $profit         = ($remoteProductPrice * $globalprofit) / 100;
                        $price          = $remoteProductPrice + $profit;
                        $currencyId = $_POST["currencyId"];
                        
                        Helpers::setProductPrice($productData["id"], $price, $currencyId);
                    }

                }
                else
                {
                    foreach($_POST["productId"] as $index => $productId) {
                        $price      = $_POST["localPrice"][$index];
                        $currencyId = $_POST["currencyId"];
                        
                        Helpers::setProductPrice($productId, $price, $currencyId);
                    }
                }
                
                $success = true;
            }
        } catch(\Exception $e) {
            $error = $e->getMessage;
        }    
        
        $currencyList           = Helpers::getCurrencyList(); 
        
        $smartyVarsCurrencyList = array();
        
        foreach($currencyList as $currencyData) {
            $currencyId=$currencyData["id"];
            $smartyVarsCurrencyList[$currencyData["id"]] = array(
                "code"      => $currencyData["code"],
                "suffix"    => $currencyData["suffix"]
            );
        }
        
        
        
        $smartyVarsProductList = array();
            
        foreach($productList as $productData) {
            
            $productId          = $productData["id"];
            $serverConfig       = Helpers::getServerConfigByProductId($productId);
        
            $apiUrl             = $serverConfig["hostname"];
            $apiKey             = $serverConfig["accesshash"];
            
            Api::setApiDetails($apiUrl, $apiKey);
            
            $remoteProductId    = $productData["configoption1"];
            //$remoteProductPrice = 0;
            /*try {
                $remoteProductData  = Api::getProductDetails($remoteProductId);
            } catch ( \Exception $e) {
                continue;
            }
            
            $remoteProductPrice = 0;
            foreach($remoteProductData as $location => $data) {
                $remoteProductPrice = $data[0]["product_monthly_price"];
                break;
            } */
            $remoteProductPrice    = Helpers::getHivelocityProductPrice($remoteProductId);
            
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
        $smarty->assign('disabled',        $disabled);
        $smarty->assign('disabledmsg',        $disabledmsg);
        $smarty->assign('crondisable',        $crondisable);
        
        $smarty->caching        = false;
        $smarty->compile_dir    = $GLOBALS['templates_compiledir'];
        
        $smarty->display(dirname(dirname(__FILE__)).'/templates/tpl/adminArea.tpl');
        
    }
}