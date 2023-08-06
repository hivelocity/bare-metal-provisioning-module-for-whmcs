<?php

namespace HivelocityPricingTool\classes;

use WHMCS\Database\Capsule;

class Addon
{
    public static function config()
    {
        $serverGroupList = Helpers::getServerGroupList();
        $serverGroupOptions = [];

        foreach ($serverGroupList as $serverGroupData) {
            $serverGroupId = $serverGroupData->id;
            $serverGroupName = $serverGroupData->name;

            $serverGroupOptions[$serverGroupId] = $serverGroupName;
        }

        $productGropupList = Helpers::getProductGroupList();
        $productGropupOptions = [];

        foreach ($productGropupList as $productGroupData) {
            $productGroupId = $productGroupData->id;
            $productGroupName = $productGroupData->name;

            $productGropupOptions[$productGroupId] = $productGroupName;
        }

        $configArray = [

            "name" => "Hivelocity Pricing Tool",
            "description" => "A simple interface allowing you to quickly change pricing for all the products using Hivelocity as the provisioning module.",
            "version" => "1.1",
            "author" => "<a target='_blank' rel='noopener noreferrer' href=''>Hivelocity</a>",
            "language" => "english",
            "fields" => [
                "priceNotification" => [
                    "FriendlyName" => "Price Change Notification",
                    "Type" => "yesno",
                    "Size" => "25",
                    "Description" => "Check if you want to receive an email notification about the price change of Hivelocity products."
                ],
                "productGroup" => [
                    "FriendlyName" => "Product Group",
                    "Type" => "dropdown",
                    "Options" => $productGropupOptions,
                    "Size" => "25",
                    "Description" => "Product Group for auto created products."
                ],
                "serverGroup" => [
                    "FriendlyName" => "Server Group",
                    "Type" => "dropdown",
                    "Options" => $serverGroupOptions,
                    "Size" => "25",
                    "Description" => "Server Group for auto created products."
                ],
            ]
        ];

        return $configArray;
    }

    public static function output($params)
    {
        $crondisable = '';

        if (function_exists('shell_exec')) {
            $output = shell_exec('crontab -l');
            if ($output) {
                if (is_numeric(strpos($output, '/HivelocityPricingTool/cron.php')) && !substr_count($output,
                        "HivelocityPricingTool") > 1) {
                    $crondisable = 'It seems cron is not setup yet.Please set the cron first.';
                }
            }
        } else {
            $crondisable = 'Please enable "shell_exec" function in your php.ini file.';
        }

        $disabled = '';
        $disabledmsg = '';

        $queryExists = Capsule::table('mod_hivelocity_cron')->select('value')->where('value', 'RunFiveMinCron')->count();

        if ($_GET['action'] == 'generateproducts') {
            Capsule::table('mod_hivelocity_cron')->updateOrCreate([
                'value' => 'RunFiveMinCron',
            ], [
                'created_at' => date('Y-m-d h:i:s')
            ]);
        }

        if ($queryExists || $_GET['action'] == 'generateproducts') {
            $disabled = 'disabled';
            $disabledmsg = 'Product sync is in progress it may take 5-10 min.Please be patient.';
        }

        if (isset($_POST["hivelocityPricingToolAction"]) && !empty($_POST["hivelocityPricingToolAction"])) {
            $action = $_POST["hivelocityPricingToolAction"];
        } else {
            $action = "";
        }

        $success = false;
        $error = false;
        $productList = Helpers::getProductList();
        try {
            if ($action == "updatePricing") {
                if ($_POST["globalchange"] == 'true') {
                    unset($_POST['DataTables_Table_0_length']);
                    $globalprofit = (float) $_POST["globalprofit"];
                    foreach ($productList as $productData) {
                        $remoteProductPrice = Helpers::getHivelocityProductPrice($productData->configoption1);
                        $profit = ($remoteProductPrice * $globalprofit) / 100;
                        $price = $remoteProductPrice + $profit;
                        $currencyId = $_POST["currencyId"];

                        Helpers::setProductPrice($productData->id, $price, $currencyId);
                    }
                } else {
                    foreach ($_POST["productId"] as $index => $productId) {
                        $price = $_POST["localPrice"][$index];
                        $currencyId = $_POST["currencyId"];

                        Helpers::setProductPrice($productId, $price, $currencyId);
                    }
                }

                $success = true;
            }
        } catch (\Exception $e) {
            $error = $e->getMessage;
        }

        $currencyList = Helpers::getCurrencyList();

        $smartyVarsCurrencyList = [];

        foreach ($currencyList as $currencyData) {
            $currencyId = $currencyData["id"];
            $smartyVarsCurrencyList[$currencyData["id"]] = [
                "code" => $currencyData["code"],
                "suffix" => $currencyData["suffix"]
            ];
        }

        $smartyVarsProductList = [];

        foreach ($productList as $productData) {
            $productId = $productData["id"];
            $serverConfig = Helpers::getServerConfigByProductId($productId);

            $apiUrl = $serverConfig["hostname"];
            $apiKey = $serverConfig["accesshash"];

            Api::setApiDetails($apiUrl, $apiKey);

            $remoteProductId = $productData["configoption1"];

            $remoteProductPrice = Helpers::getHivelocityProductPrice($remoteProductId);

            $usdRate = Helpers::getCurrencyRate("USD");

            if ($usdRate === false) {
                break;
            }

            $remoteProductPrice = $remoteProductPrice / $usdRate;

            $smartyVarsProductList[$productId] = [
                "name" => $productData["name"]
            ];

            foreach ($currencyList as $currencyData) {
                $currencyId = $currencyData["id"];
                $productPrice = Helpers::getProductPrice($productId, $currencyId);

                $currencyRate = $currencyData["rate"];

                $remoteProductPriceConverted = $remoteProductPrice * $currencyRate;

                $profit = $productPrice - $remoteProductPriceConverted;
                if ($remoteProductPrice != 0) {
                    $profitPercentage = ($profit / $remoteProductPrice) * 100;
                }

                $smartyVarsProductList[$productId]["remotePrice"][$currencyId] = number_format($remoteProductPriceConverted,
                    2);
                $smartyVarsProductList[$productId]["localPrice"][$currencyId] = number_format($productPrice, 2);
                $smartyVarsProductList[$productId]["profit"][$currencyId] = number_format($profitPercentage, 2);
            }
        }

        $smarty = new \Smarty();

        $smarty->assign('productList', $smartyVarsProductList);
        $smarty->assign('currencyList', $smartyVarsCurrencyList);
        $smarty->assign('success', $success);
        $smarty->assign('error', $error);
        $smarty->assign('disabled', $disabled);
        $smarty->assign('disabledmsg', $disabledmsg);
        $smarty->assign('crondisable', $crondisable);

        $smarty->caching = false;
        $smarty->compile_dir = $GLOBALS['templates_compiledir'];

        $smarty->display(dirname(dirname(__FILE__)) . '/templates/tpl/adminArea.tpl');
    }

    public static function databaseManagement()
    {
        if (!Capsule::schema()->hasTable('mod_hivelocity_cron')) {
            Capsule::schema()->create('mod_hivelocity_cron', function ($table) {
                $table->increments('id');
                $table->string('value');
                $table->timestamps();
            });
        }

        if (!Capsule::schema()->hasTable('HivelocityProductPrices')) {
            Capsule::schema()->create('HivelocityProductPrices', function ($table) {
                $table->increments('hivelocityProductId');
                $table->decimal('hivelocityProductPrice', 10, 3);
            });
        }

        if (!Capsule::schema()->hasTable('HivelocityDeploymentCorrelation')) {
            Capsule::schema()->create('HivelocityDeploymentCorrelation', function ($table) {
                $table->increments('whmcsServiceId');
                $table->foreignId('hivelocityDeploymentId')->index();
            });
        }

        if (!Capsule::schema()->hasTable('HivelocityOrderCorrelation')) {
            Capsule::schema()->create('HivelocityOrderCorrelation', function ($table) {
                $table->increments('whmcsServiceId');
                $table->foreignId('hivelocityOrderId')->index();
            });
        }

        if (!Capsule::schema()->hasTable('HivelocityServiceCorrelation')) {
            Capsule::schema()->create('HivelocityServiceCorrelation', function ($table) {
                $table->increments('whmcsServiceId');
                $table->foreignId('hivelocityServiceId')->index();
            });
        }

        if (!Capsule::schema()->hasTable('HivelocityDeviceCorrelation')) {
            Capsule::schema()->create('HivelocityDeviceCorrelation', function ($table) {
                $table->increments('whmcsServiceId');
                $table->foreignId('hivelocityDeviceId')->index();
            });
        }

        if (!Capsule::schema()->hasTable('HivelocityDomainCorrelation')) {
            Capsule::schema()->create('HivelocityDomainCorrelation', function ($table) {
                $table->increments('hivelocityDomainId');
                $table->foreignId('whmcsUserId')->index();
                $table->foreignId('whmcsServiceId')->index();
            });
        }

        Capsule::table('mod_hivelocity_cron')->insert([
            'value' => 'RunFiveMinCron',
            'created_at' => date('Y-m-d h:i:s'),
        ]);
    }
}