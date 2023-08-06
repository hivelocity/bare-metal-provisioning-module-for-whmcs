<?php

namespace HivelocityPricingTool\classes;

use WHMCS\Database\Capsule;
use Exception;

class Helpers
{

    public static function debugLog($desc, $data)
    {
        logmodulecall("HivelocityPricingTool Debug Log", $desc, $data, "", "");
    }

    public static function getAddonConfig(): array
    {
        $configs = Capsule::table('tbladdonmodules')->where('module', 'HivelocityPricingTool')->get();

        $addonConfig = [];

        foreach ($configs as $config) {
            $addonConfig[$config->setting] = $config->value;
        }

        return $addonConfig;
    }

    public static function isNotificationEnabled(): bool
    {
        $value = Capsule::table('tbladdonmodules')->where('module', 'HivelocityPricingTool')
                ->where('setting', 'priceNotification')->first()->value ?? '';

        return $value == 'on';
    }

    public static function saveHivelocityProductPrice($hivelocityProductId, $hivelocityProductPrice): void
    {
        Capsule::table('HivelocityProductPrices')->updateOrInsert([
            'hivelocityProductId' => $hivelocityProductId,
        ], [
            'hivelocityProductPrice' => $hivelocityProductPrice,
        ]);
    }

    public static function getHivelocityProductPrice($hivelocityProductId)
    {
        return Capsule::table('HivelocityProductPrices')->where('hivelocityProductId', $hivelocityProductId)
                ->first()->hivelocityProductPrice ?? false;
    }

    public static function getLocationName($locationId)
    {
        $temp = explode("-", $locationId);

        if (isset($temp[1])) {
            $locationId = $temp[1];
        } else {
            $locationId = $temp[0];
        }

        $locationArray = [
            'ATL2' => 'Atlanta, GA',
            'ORD1' => 'Chicago, IL',
            'DAL1' => 'Dallas, TX',
            'LAX1' => 'Los Angeles, CA',
            'LAX2' => 'Los Angeles 2, CA',
            'MIA1' => 'Miami, FL',
            'NYC1' => 'New York City, NY',
            'JFK1' => 'Newark, NY',
            'IAD1' => 'Reston, VA',
            'SEA1' => 'Seattle, WA',
            'SNV1' => 'Sunnyvale, CA',
            'TPA1' => 'Tampa, FL',
            'TPA2' => 'Tampa 2, FL',
            'YYZ1' => 'Toronto, Canada',
            'YXX1' => 'Vancouver, Canada',
            'AMS1' => 'Amsterdam, Netherlands',
            'FRA1' => 'Frankfurt, Germany',
            'TOJ1' => 'Madrid, Spain',
            'CDG1' => 'Paris, France',
            'LCY1' => 'London, England',
            'LIN1' => 'Milan, Italy',
            'ARN1' => 'Stockholm, Sweden',
            'HKG1' => 'Hong Kong, China',
            'ICN1' => 'Seoul, South Korea',
            'SIN1' => 'Singapore, Singapore',
            'SYD1' => 'Sydney, Australia',
            'NRT1' => 'Tokyo, Japan',
            'FLL1' => 'Fort Lauderdale, FL',
            'BOM1' => 'Mumbai, India',
            'JHN1' => 'Johannesburg, South Africa',
            'VNO1' => 'Vilnius, Lithuania',
            'DEL1' => 'Delhi, India',
            'PNQ1' => 'Pune, India',
            'POZ1' => 'Poznan, Poland',
            'NBO1' => 'Nairobi, Kenya',
            'ATH1' => 'Athens, Greece',
            'AUS1' => 'Austin, TX',
            'RIX1' => 'Riga, Latvia',
            'MEX1' => 'Mexico City, Mexico',
            'IND1' => 'Indianapolis, Indiana',
            'SLC1' => 'Salt Lake City, Utah',
            'YYZ2' => 'Mississauga, CA',
            'BOS1' => 'Boston, Massachusetts',
            'LHR2' => 'London Slough, England',
            'IAD3' => 'Reston Sterling, Virginia',
            'PHX1' => 'Phoenix, Arizona',
            'EWR1' => 'Weehawken, New Jersey',
            'DEN1' => 'Denver, Colorado',
        ];

        $locationName = $locationArray[$locationId];

        if (empty($locationName)) {
            $locationName = $locationId;
        }

        return $locationName;
    }

    public static function getServerConfigByProductId(int $productId)
    {
        $serverGroupId = Capsule::table('tblproducts')->where('id', $productId)->select('servergroup')
                ->first()->servergroup ?? false;

        if ($serverGroupId) {
            return self::getServerConfigByServerGroupId($serverGroupId);
        } else {
            return false;
        }
    }

    public static function getServerConfigByServerGroupId(int $serverGroupId)
    {
        $serverGroupRel = Capsule::table('tblservergroupsrel')->where('groupid', $serverGroupId)->get();

        if ($serverGroupRel->count() < 1) {
            return false;
        }
        $serverIds = [];
        foreach ($serverGroupRel as $rel) {
            $serverIds[] = $rel->serverid;
        }

        $data = Capsule::table('tblservers')->whereIn('id', $serverIds)->where('hostname', 'LIKE', '%hivelocity%')
            ->first();

        return (array) $data ?? false;
    }

    public static function getServerGroupList(): array
    {
        $data = Capsule::table('tblservergroups')->get()->toArray();

        return self::toArray($data);
    }

    public static function addProductCustomField(int $productId)
    {
        Capsule::table('tblcustomfields')->insert([
            'type' => 'product',
            'relid' => $productId,
            'fieldname' => 'hivelocityDeviceId|Device ID',
            'fieldtype' => 'text',
            'adminonly' => 'on',
        ]);
    }

    public static function hideProduct(int $productId)
    {
        Capsule::table('tblproducts')->where('id', $productId)->update([
            'hidden' => 1,
        ]);
    }

    public static function unHideProduct(int $productId)
    {
        Capsule::table('tblproducts')->where('id', $productId)->update([
            'hidden' => 0,
        ]);
    }

    public static function hideConfigOption(int $configOptionId)
    {
        Capsule::table('tblproductconfigoptions')->where('id', $configOptionId)->update([
            'hidden' => 1,
        ]);
    }

    public static function unHideConfigOption(int $configOptionId)
    {
        Capsule::table('tblproductconfigoptions')->where('id', $configOptionId)->update([
            'hidden' => 0,
        ]);
    }

    public static function hideConfigOptionSub(int $configOptionSubId)
    {
        Capsule::table('tblproductconfigoptionssub')->where('id', $configOptionSubId)->update([
            'hidden' => 1,
        ]);
    }

    public static function unHideConfigOptionSub(int $configOptionSubId)
    {
        Capsule::table('tblproductconfigoptionssub')->where('id', $configOptionSubId)->update([
            'hidden' => 0,
        ]);
    }

    public static function getProductList(): array
    {
        $data = Capsule::table('tblproducts')->where('servertype', 'Hivelocity')->get()->toArray();

        return self::toArray($data);
    }

    public static function getProductGroupList(): array
    {
        $data = Capsule::table('tblproductgroups')->get()->toArray();

        return self::toArray($data);
    }

    public static function getConfigOptionList(int $configOptionGroupId)
    {
        $data = Capsule::table('tblproductconfigoptions')->where('gid', $configOptionGroupId)->get()->toArray();

        return self::toArray($data);
    }

    public static function getConfigOptionSubList(int $configOptionId)
    {
        $data = Capsule::table('tblproductconfigoptionssub')->where('configid', $configOptionId)->get()->toArray();

        return self::toArray($data);
    }

    public static function getConfigOptionsGroupId(int $productId)
    {
        return Capsule::table('tblproductconfiggroups')->where('tblproductconfiggroups.name', 'LIKE', '%Hivelocity%')
                ->join('tblproductconfiglinks', function ($join) use ($productId) {
                    $join->on('tblproductconfiggroups.id', '=', 'tblproductconfiglinks.gid')
                        ->where('tblproductconfiglinks.pid', $productId);
                })->where('tblproductconfiglinks.pid', $productId)->select('tblproductconfiggroups.id')
                ->first()->id ?? false;
    }

    public static function createConfigOptionsGroup(int $productId)
    {
        $productName = self::getProductName($productId);
        $productName = htmlspecialchars_decode($productName, ENT_QUOTES);

        $name = "Configurable options for $productName product - Auto generated by module Hivelocity Bare-Metal";
        $name = htmlspecialchars($name, ENT_QUOTES);

        return Capsule::table('tblproductconfiggroups')->insertGetId([
            'name' => $name
        ]);
    }

    public static function getConfigOptionsLinkId(int $productId, int $groupId)
    {
        return Capsule::table('tblproductconfiglinks')->where('gid', $groupId)->where('pid', $productId)
                ->first()->id ?? false;
    }

    public static function createConfigOptionsLink(int $productId, int $groupId)
    {
        Capsule::table('tblproductconfiglinks')->insert([
            'gid' => $groupId,
            'pid' => $productId,
        ]);
    }

    public static function getConfigOptionId(int $groupId, string $name)
    {
        return Capsule::table('tblproductconfigoptions')->where('gid', $groupId)->where('optionname', $name)
                ->first()->id ?? false;
    }

    public static function createConfigOption(int $groupId, string $name)
    {
        Capsule::table('tblproductconfigoptions')->insert([
            'gid' => $groupId,
            'optionname' => $name,
            'optiontype' => 1,
        ]);
    }

    public static function getConfigOptionSubId(int $optionId, string $name)
    {
        return Capsule::table('tblproductconfigoptionssub')->where('configid', $optionId)->where('optionname', $name)
                ->first()->id ?? false;
    }

    public static function createConfigOptionSub(int $optionId, string $name)
    {
        Capsule::table('tblproductconfigoptionssub')->insert([
            'configid' => $optionId,
            'optionname' => $name,
        ]);
    }

    public static function clearConfigOptionSub(int $optionId)
    {
        Capsule::table('tblproductconfigoptionssub')->where('configid', $optionId)->delete();
    }

    public static function createConfigOptions($productId, $remoteProductId)
    {
        $serverConfig = Helpers::getServerConfigByProductId($productId);
        $apiUrl = $serverConfig["hostname"];
        $apiKey = $serverConfig["accesshash"];

        Api::setApiDetails($apiUrl, $apiKey);

        $remoteProductDetails = Api::getProductDetails($remoteProductId);
        $remoteProductOS = Api::getProductOS($remoteProductId);
        $remoteProductOptions = Api::getProductOptions($remoteProductId);

        $configOptionsGroupId = Helpers::getConfigOptionsGroupId($productId);
        $newGroup = false;

        if ($configOptionsGroupId == false) {
            $configOptionsGroupId = Helpers::createConfigOptionsGroup($productId);
            $newGroup = true;
        }

        $configOptionsLinkId = Helpers::getConfigOptionsLinkId($productId, $configOptionsGroupId);
        if ($configOptionsLinkId == false) {
            Helpers::createConfigOptionsLink($productId, $configOptionsGroupId);
        }

        $currencyId = Helpers::getCurrencyId("USD");

        if ($currencyId == false) {
            throw new Exception("Currency 'USD' Not Configured");
        }

        $processedOptions = [];
        //------------------------------------------------------------------------------

        $locationConfigOptionId = Helpers::getConfigOptionId($configOptionsGroupId, "Location");
        if ($locationConfigOptionId == false) {
            Helpers::createConfigOption($configOptionsGroupId, "Location");
            $locationConfigOptionId = Helpers::getConfigOptionId($configOptionsGroupId, "Location");
        }

        //Helpers::clearConfigOptionSub($locationConfigOptionId);

        $processedSubOptions = [];

        foreach ($remoteProductDetails as $location => $details) {
            $name = $location . "|" . Helpers::getLocationName($location);
            $configOptionSubId = Helpers::getConfigOptionSubId($locationConfigOptionId, $name);

            if ($configOptionSubId == false) {
                Helpers::createConfigOptionSub($locationConfigOptionId, $name);
                $configOptionSubId = Helpers::getConfigOptionSubId($locationConfigOptionId, $name);
            }

            $price = floatval($details[0]["monthly_location_premium"]);

            $usdRate = Helpers::getCurrencyRate("USD");
            $basePrice = $price / $usdRate;

            $currencyList = Helpers::getCurrencyList();
            foreach ($currencyList as $currency) {
                $currencyId = $currency["id"];
                $currencyRate = $currency["rate"];
                $priceConverted = $basePrice * $currencyRate;
                Helpers::setConfigOptionPrice($configOptionSubId, $priceConverted, $currencyId);
            }

            $processedSubOptions[] = $configOptionSubId;
        }

        $localConfigOptionSubList = Helpers::getConfigOptionSubList($locationConfigOptionId);

        foreach ($localConfigOptionSubList as $localConfigOptionSubData) {
            $localConfigOptionSubId = $localConfigOptionSubData["id"];

            if (in_array($localConfigOptionSubId, $processedSubOptions)) {
                Helpers::unHideConfigOptionSub($localConfigOptionSubId);
            } else {
                Helpers::hideConfigOptionSub($localConfigOptionSubId);
            }
        }

        $processedOptions[] = $locationConfigOptionId;
        //------------------------------------------------------------------------------

        $osConfigOptionId = Helpers::getConfigOptionId($configOptionsGroupId, "Operating System");
        if ($osConfigOptionId == false) {
            Helpers::createConfigOption($configOptionsGroupId, "Operating System");
            $osConfigOptionId = Helpers::getConfigOptionId($configOptionsGroupId, "Operating System");
        }

        //Helpers::clearConfigOptionSub($osConfigOptionId);

        $processedSubOptions = [];

        foreach ($remoteProductOS as $os) {
            $name = $os["name"] . "|" . $os["name"];
            $configOptionSubId = Helpers::getConfigOptionSubId($osConfigOptionId, $name);

            if ($configOptionSubId == false) {
                Helpers::createConfigOptionSub($osConfigOptionId, $name);
                $configOptionSubId = Helpers::getConfigOptionSubId($osConfigOptionId, $name);
            }

            $price = floatval($os["monthlyPrice"]);

            $usdRate = Helpers::getCurrencyRate("USD");
            $basePrice = $price / $usdRate;

            $currencyList = Helpers::getCurrencyList();

            foreach ($currencyList as $currency) {
                $currencyId = $currency["id"];
                $currencyRate = $currency["rate"];
                $priceConverted = $basePrice * $currencyRate;
                Helpers::setConfigOptionPrice($configOptionSubId, $priceConverted, $currencyId);
            }

            $processedSubOptions[] = $configOptionSubId;
        }

        $localConfigOptionSubList = Helpers::getConfigOptionSubList($osConfigOptionId);

        foreach ($localConfigOptionSubList as $localConfigOptionSubData) {
            $localConfigOptionSubId = $localConfigOptionSubData["id"];

            if (in_array($localConfigOptionSubId, $processedSubOptions)) {
                Helpers::unHideConfigOptionSub($localConfigOptionSubId);
            } else {
                Helpers::hideConfigOptionSub($localConfigOptionSubId);
            }
        }

        $processedOptions[] = $osConfigOptionId;
        //------------------------------------------------------------------------------

        $remoteProductOptions = Helpers::filterProductOptions($remoteProductOptions);

        foreach ($remoteProductOptions as $optionName => $subOptions) {
            $configOptionId = Helpers::getConfigOptionId($configOptionsGroupId, $optionName);

            if ($configOptionId == false) {
                Helpers::createConfigOption($configOptionsGroupId, $optionName);
                $configOptionId = Helpers::getConfigOptionId($configOptionsGroupId, $optionName);
            }

            //Helpers::clearConfigOptionSub($configOptionId);
            $processedSubOptions = [];

            foreach ($subOptions as $subOption) {
                $name = $subOption["id"] . "|" . $subOption["name"];
                $configOptionSubId = Helpers::getConfigOptionSubId($configOptionId, $name);

                if ($configOptionSubId == false) {
                    Helpers::createConfigOptionSub($configOptionId, $name);
                    $configOptionSubId = Helpers::getConfigOptionSubId($configOptionId, $name);
                }

                $price = floatval($subOption["monthlyPrice"]);

                $usdRate = Helpers::getCurrencyRate("USD");
                $basePrice = $price / $usdRate;

                $currencyList = Helpers::getCurrencyList();

                foreach ($currencyList as $currency) {
                    $currencyId = $currency["id"];
                    $currencyRate = $currency["rate"];
                    $priceConverted = $basePrice * $currencyRate;
                    Helpers::setConfigOptionPrice($configOptionSubId, $priceConverted, $currencyId);
                }
                $processedSubOptions[] = $configOptionSubId;
            }

            $localConfigOptionSubList = Helpers::getConfigOptionSubList($configOptionId);

            foreach ($localConfigOptionSubList as $localConfigOptionSubData) {
                $localConfigOptionSubId = $localConfigOptionSubData["id"];

                if (in_array($localConfigOptionSubId, $processedSubOptions)) {
                    Helpers::unHideConfigOptionSub($localConfigOptionSubId);
                } else {
                    Helpers::hideConfigOptionSub($localConfigOptionSubId);
                }
            }

            $processedOptions[] = $configOptionId;
        }

        $localConfigOptionList = Helpers::getConfigOptionList($configOptionsGroupId);

        foreach ($localConfigOptionList as $localConfigOptionData) {
            $localConfigOptionId = $localConfigOptionData["id"];

            if (in_array($localConfigOptionId, $processedOptions)) {
                Helpers::unHideConfigOption($localConfigOptionId);
            } else {
                Helpers::hideConfigOption($localConfigOptionId);
            }
        }

        return;
    }

    public static function filterProductOptions($productOptions): array
    {
        $expectedOptions = [
            "Control Panel",
            "Managed Services",
            "LiteSpeed",
            "WHMCS",
            "Bandwidth",
            "Load Balancing",
            "DDOS",
            "Daily Backup & Rapid Restore",
            "Cloud Storage",
            "Data Migration",
        ];

        $filteredOptions = [];

        foreach ($expectedOptions as $optionName) {
            if (isset($productOptions[$optionName]) && !empty($productOptions[$optionName])) {
                $filteredOptions[$optionName] = $productOptions[$optionName];
            }
        }

        return $filteredOptions;
    }

    public static function setConfigOptionPrice(int $optionSubId, $price, int $currencyId)
    {
        Capsule::table('tblpricing')->updateOrInsert([
            'type' => 'configoptions',
            'relid' => $optionSubId,
            'currency' => $currencyId,
        ], [
            'monthly' => $price,
            'msetupfee' => 0,
        ]);
    }

    public static function setProductPrice(int $productId, $price, int $currencyId)
    {
        Capsule::table('tblpricing')->updateOrInsert([
            'type' => 'product',
            'relid' => $productId,
            'currency' => $currencyId,
        ],[
            'monthly' => $price
        ]);
    }

    public static function getProductIdByRemoteProductId($remoteProductId)
    {
        return Capsule::table('tblproducts')->where('configoption1', $remoteProductId)->select('id')
                ->first()->id ?? false;
    }

    public static function getProductName(int $productId)
    {
        return Capsule::table('tblproducts')->where('id', $productId)->select('name')->first()->name ?? false;
    }

    public static function getCurrencyId($currencyCode)
    {
        return Capsule::table('tblcurrencies')->where('code', $currencyCode)->select('id')->first()->id ?? false;
    }

    public static function getCurrencyRate($currencyCode)
    {
        return Capsule::table('tblcurrencies')->where('code', $currencyCode)->select('rate')->first()->rate ?? false;
    }

    public static function getCurrencyList(): array
    {
        $data = Capsule::table('tblcurrencies')->get()->toArray();

        return self::toArray($data);
    }

    public static function getProductPrice($productId, $currencyId)
    {
        return Capsule::table('tblpricing')->where('type', 'product')->where('relid', $productId)
                ->where('currency', $currencyId)->select('monthly')->first()->monthly ?? false;
    }

    public static function toArray(array $data): array
    {
        if ($data) {
            return json_decode(json_encode($data), true);
        } else {
            return [];
        }
    }

}
