<?php

namespace HivelocityPricingTool\classes;

use Illuminate\Database\Capsule\Manager as Capsule;

class Cron
{
    static public function priceChangeNotify()
    {
        $productList = Helpers::getProductList();

        foreach ($productList as $productData) {
            set_time_limit(60);

            $productId = $productData['id'];
            $serverConfig = Helpers::getServerConfigByProductId($productId);

            $apiUrl = $serverConfig["hostname"];
            $apiKey = $serverConfig["accesshash"];

            Api::setApiDetails($apiUrl, $apiKey);

            try {
                $remoteProductId = $productData['configoption1'];
                $remoteProductData = Api::getProductDetails($remoteProductId);
            } catch (\Exception $e) {
                continue;
            }

            $remoteProductPrice = 0;
            foreach ($remoteProductData as $location => $data) {
                $remoteProductPrice = $data[0]["product_monthly_price"];
                break;
            }

            $savedRemoteProductPrice = Helpers::getHivelocityProductPrice($remoteProductId);

            if ($savedRemoteProductPrice === false) {
                Helpers::saveHivelocityProductPrice($remoteProductId, $remoteProductPrice);
            } elseif ($savedRemoteProductPrice != $remoteProductPrice) {
                Helpers::saveHivelocityProductPrice($remoteProductId, $remoteProductPrice);

                if (Helpers::isNotificationEnabled()) {
                    $command = 'SendAdminEmail';

                    $postData = [
                        'messagename' => 'Hivelocity Product Price Change',
                        'mergefields' => [
                            'hivelocityProductId' => $remoteProductId,
                            'oldPrice' => number_format($savedRemoteProductPrice, 2) . " USD",
                            'newPrice' => number_format($remoteProductPrice, 2) . " USD"
                        ],
                    ];

                    $results = localAPI($command, $postData);
                }
            }
        }
    }

    static public function synchronizeProducts()
    {
        $addonConfig = Helpers::getAdonConfig();
        $serverGroupId = $addonConfig["serverGroup"];
        $productGroupId = $addonConfig["productGroup"];

        $serverConfig = Helpers::getServerConfigByServerGroupId($serverGroupId);

        $apiUrl = $serverConfig["hostname"];
        $apiKey = $serverConfig["accesshash"];

        Api::setApiDetails($apiUrl, $apiKey);

        $remoteProductListRaw = Api::getProductList();
        $remoteProductList = [];

        foreach ($remoteProductListRaw as $location => $list) {
            foreach ($list as $remoteProductData) {
                $remoteProductId = $remoteProductData["product_id"];

                if (isset($remoteProductList[$remoteProductId])) {
                    if ($remoteProductData["stock"] != "unavailable") {
                        $remoteProductList[$remoteProductId] = $remoteProductData;
                    }
                } else {
                    $remoteProductList[$remoteProductId] = $remoteProductData;
                }
            }
        }

        $currencyList = Helpers::getCurrencyList();
        foreach ($currencyList as $currency) {
            $currencyId = $currency["id"];
        }

        $processedProducts = [];

        foreach ($remoteProductList as $remoteProductId => $remoteProductData) {
            set_time_limit(120); //long loop

            $localProductId = Helpers::getProductIdByRemoteProductId($remoteProductId);

            if ($localProductId == false && $remoteProductData["stock"] != "unavailable") {
                //create product

                $billingInfoList = Api::getBillingInfoList();
                $billingId = $billingInfoList[0]["id"];

                $price = floatval($remoteProductData["product_monthly_price"]);

                $usdRate = Helpers::getCurrencyRate("USD");
                $basePrice = $price / $usdRate;

                $currencyList = Helpers::getCurrencyList();
                $pricing = [];

                foreach ($currencyList as $currency) {
                    $currencyId = $currency["id"];
                    $currencyRate = $currency["rate"];
                    $priceConverted = $basePrice * $currencyRate;
                    $pricing[$currencyId]["monthly"] = $priceConverted;
                }

                $desc = '';
                if ($remoteProductData["product_bandwidth"]) {
                    $desc .= "Bandwidth : " . $remoteProductData["product_bandwidth"];
                }

                if ($remoteProductData["product_cpu"]) {
                    $desc .= "<br>CPU : " . $remoteProductData["product_cpu"];
                }

                if ($remoteProductData["product_memory"]) {
                    $desc .= "<br>Memory : " . $remoteProductData["product_memory"];
                }

                if ($remoteProductData["product_drive"]) {
                    $desc .= "<br>Drive : " . $remoteProductData["product_drive"];
                }

                $result = WhmcsApi::AddProduct([
                    "name" => $remoteProductData["product_id"] . " - " . $remoteProductData["product_cpu"] . " - " . $remoteProductData["product_memory"] . " - " . $remoteProductData["product_drive"],
                    "gid" => $productGroupId,
                    "type" => "server",
                    "paytype" => "recurring",
                    "autosetup" => "payment",
                    "pricing" => $pricing,
                    "servergroupid" => $serverGroupId,
                    "module" => "Hivelocity",
                    "configoption1" => $remoteProductId,
                    "configoption2" => $billingId,
                    "description" => $desc,
                ]);

                $localProductId = $result["pid"];

                Helpers::addProductCustomField($localProductId);
                Helpers::createConfigOptions($localProductId, $remoteProductId);

                $processedProducts[] = $localProductId;
            } elseif ($localProductId != false && $remoteProductData["stock"] != "unavailable") {
                //update product

                Helpers::createConfigOptions($localProductId, $remoteProductId);
                $processedProducts[] = $localProductId;
            }
        }

        $localProductList = Helpers::getProductList();

        foreach ($localProductList as $localProductData) {
            $localProductId = $localProductData['id'];

            if (in_array($localProductId, $processedProducts)) {
                Helpers::unhideProduct($localProductId);
            } else {
                Helpers::hideProduct($localProductId);
            }
        }
    }
}
