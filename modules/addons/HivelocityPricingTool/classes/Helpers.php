<?php

namespace HivelocityPricingTool\classes;

use Illuminate\Database\Capsule\Manager;
use WHMCS\Database\Capsule;

class Helpers
{

    public static function debugLog($desc, $data)
    {
        logmodulecall("HivelocityPricingTool Debug Log", $desc, $data, "", "");
    }

    public static function getAdonConfig()
    {
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT * FROM tbladdonmodules WHERE module = 'HivelocityPricingTool'";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $pdo->commit();

        $addonConfig = [];

        foreach ($rows as $row) {
            $addonConfig[$row["setting"]] = $row["value"];
        }

        return $addonConfig;
    }

    public static function isNotificationEnabled(): bool
    {
        $value = Capsule::table('tbladdonmodules')->where('module', 'HivelocityPricingTool')->where('setting', 'priceNotification')->first()->value ?? '';

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

    public static function saveHivelocityDeploymentCorrelation($whmcsServiceId, $hivelocityDeploymentId)
    {
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "INSERT INTO HivelocityDeploymentCorrelation (whmcsServiceId, hivelocityDeploymentId) VALUES (?,?) ON DUPLICATE KEY UPDATE hivelocityDeploymentId = ?;";
        $statement = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId, $hivelocityDeploymentId, $hivelocityDeploymentId]);
        $pdo->commit();
    }

    public static function getHivelocityDeploymentCorrelation($whmcsServiceId)
    {
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT hivelocityDeploymentId FROM HivelocityDeploymentCorrelation WHERE whmcsServiceId = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["hivelocityDeploymentId"])) {
            return $row["hivelocityDeploymentId"];
        } else {
            return false;
        }
    }

    public static function saveHivelocityServiceCorrelation($whmcsServiceId, $hivelocityServiceId)
    {
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "INSERT INTO HivelocityServiceCorrelation (whmcsServiceId, hivelocityServiceId) VALUES (?,?) ON DUPLICATE KEY UPDATE hivelocityServiceId = ?;";
        $statement = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId, $hivelocityServiceId, $hivelocityServiceId]);
        $pdo->commit();
    }

    public static function getHivelocityServiceCorrelation($whmcsServiceId)
    {
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT hivelocityServiceId FROM HivelocityServiceCorrelation WHERE whmcsServiceId = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["hivelocityServiceId"])) {
            return $row["hivelocityServiceId"];
        } else {
            return false;
        }
    }

    public static function saveHivelocityDeviceCorrelation($whmcsServiceId, $hivelocityDeviceId)
    {
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "INSERT INTO HivelocityDeviceCorrelation (whmcsServiceId, hivelocityDevicetId) VALUES (?,?) ON DUPLICATE KEY UPDATE hivelocityDevicetId = ?;";
        $statement = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId, $hivelocityDeviceId, $hivelocityDeviceId]);
        $pdo->commit();
    }

    public static function getHivelocityDeviceCorrelation($whmcsServiceId)
    {
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT hivelocityDevicetId FROM HivelocityDeviceCorrelation WHERE whmcsServiceId = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["hivelocityDevicetId"])) {
            return $row["hivelocityDevicetId"];
        } else {
            return false;
        }
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
        $rels = Capsule::table('tblservergroupsrel')->where('groupid', $serverGroupId)->get();

        if ($rels->count() < 1) {
            return false;
        }
        $serverIds = [];
        foreach ($rels as $rel) {
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

    public static function getProductCustomFieldId($productId)
    {
        $productId = intval($productId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT id FROM tblcustomfields WHERE type = 'product' AND relid = '$productId' AND fieldname LIKE 'hivelocityDeviceId%'";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $row = $statement->fetch();
        $pdo->commit();

        if (!isset($row["id"]) || empty($row["id"])) {
            return false;
        }

        return $row["id"];
    }

    public static function addProductCustomField($productId)
    {
        $productId = intval($productId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "INSERT INTO tblcustomfields (type, relid, fieldname, fieldtype, adminonly) VALUES ('product', $productId, 'hivelocityDeviceId|Device ID', 'text', 'on')";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $pdo->commit();
    }

    public static function hideProduct($productId)
    {
        $productId = intval($productId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "UPDATE tblproducts SET hidden = 1 WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$productId]);
        $pdo->commit();
    }

    public static function unhideProduct($productId)
    {
        $productId = intval($productId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "UPDATE tblproducts SET hidden = 0 WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$productId]);
        $pdo->commit();
    }

    public static function hideConfigOption($configOptionId)
    {
        $productId = intval($productId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "UPDATE tblproductconfigoptions SET hidden = 1 WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$configOptionId]);
        $pdo->commit();
    }

    public static function unHideConfigOption($configOptionId)
    {
        $productId = intval($productId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "UPDATE tblproductconfigoptions SET hidden = 0 WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$configOptionId]);
        $pdo->commit();
    }

    public static function hideConfigOptionSub($configOptionSubId)
    {
        $productId = intval($productId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "UPDATE tblproductconfigoptionssub SET hidden = 1 WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$configOptionSubId]);
        $pdo->commit();
    }

    public static function unHideConfigOptionSub($configOptionSubId)
    {
        $productId = intval($productId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "UPDATE tblproductconfigoptionssub SET hidden = 0 WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$configOptionSubId]);
        $pdo->commit();
    }

    public static function getProductModule($productId)
    {
        $productId = intval($productId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT servertype FROM tblproducts WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$productId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (!isset($row["servertype"]) || empty($row["servertype"])) {
            return false;
        }

        return $row["servertype"];
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

    public static function getConfigOptionList($configOptionGroupId)
    {
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT * FROM tblproductconfigoptions WHERE gid = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$configOptionGroupId]);
        $rows = $statement->fetchAll();
        $pdo->commit();

        return $rows;
    }

    public static function getConfigOptionSubList($configOptionId)
    {
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT * FROM tblproductconfigoptionssub WHERE configid = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$configOptionId]);
        $rows = $statement->fetchAll();
        $pdo->commit();

        return $rows;
    }

    public static function getConfigOptionsGroupId($productId)
    {
        $productId = intval($productId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT tblproductconfiggroups.id FROM tblproductconfiggroups INNER JOIN tblproductconfiglinks ON tblproductconfiggroups.id = tblproductconfiglinks.gid WHERE tblproductconfiggroups.name LIKE '%Hivelocity%' AND tblproductconfiglinks.pid = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$productId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (!isset($row["id"]) || empty($row["id"])) {
            return false;
        }

        return $row["id"];
    }

    public static function createConfigOptionsGroup($productId)
    {
        $productId = intval($productId);

        $productName = self::getProductName($productId);
        $productName = htmlspecialchars_decode($productName, ENT_QUOTES);

        $name = "Configurable options for $productName product - Auto generated by module Hivelocity Bare-Metal";
        $name = htmlspecialchars($name, ENT_QUOTES);

        $pdo = Manager::connection()->getPdo();

        $pdo->beginTransaction();
        $query = "INSERT INTO tblproductconfiggroups (name) VALUES (?)";
        $statement = $pdo->prepare($query);
        $statement->execute([$name]);
        $pdo->commit();

        $pdo->beginTransaction();
        $query = "SELECT id FROM tblproductconfiggroups WHERE name = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$name]);
        $row = $statement->fetch();
        $pdo->commit();

        if (!isset($row["id"]) || empty($row["id"])) {
            return false;
        }

        return $row["id"];
    }

    public static function getConfigOptionsLinkId($productId, $groupId)
    {
        $productId = intval($productId);
        $groupId = intval($groupId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT id FROM tblproductconfiglinks WHERE gid = ? AND pid = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$groupId, $productId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (!isset($row["id"]) || empty($row["id"])) {
            return false;
        }

        return $row["id"];
    }

    public static function createConfigOptionsLink($productId, $groupId)
    {
        $productId = intval($productId);
        $groupId = intval($groupId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "INSERT INTO tblproductconfiglinks (gid, pid) VALUES (?, ?)";
        $statement = $pdo->prepare($query);
        $statement->execute([$groupId, $productId]);
        $pdo->commit();
    }

    public static function getConfigOptionId($groupId, $name)
    {
        $groupId = intval($groupId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT id FROM tblproductconfigoptions WHERE gid = ? AND optionname = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$groupId, $name]);
        $row = $statement->fetch();
        $pdo->commit();

        if (!isset($row["id"]) || empty($row["id"])) {
            return false;
        }

        return $row["id"];
    }

    public static function createConfigOption($groupId, $name)
    {
        $groupId = intval($groupId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "INSERT INTO tblproductconfigoptions (gid, optionname, optiontype) VALUES (?, ?, 1)";
        $statement = $pdo->prepare($query);
        $statement->execute([$groupId, $name]);
        $pdo->commit();
    }

    public static function getConfigOptionSubId($optionId, $name)
    {
        $optionId = intval($optionId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT id FROM tblproductconfigoptionssub WHERE configid = ? AND optionname = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$optionId, $name]);
        $row = $statement->fetch();
        $pdo->commit();

        if (!isset($row["id"]) || empty($row["id"])) {
            return false;
        }

        return $row["id"];
    }

    public static function createConfigOptionSub(int $optionId, string $name)
    {
        $optionId = intval($optionId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "INSERT INTO tblproductconfigoptionssub (configid, optionname) VALUES (?, ?)";
        $statement = $pdo->prepare($query);
        $statement->execute([$optionId, $name]);
        $pdo->commit();
    }

    public static function clearConfigOptionSub($optionId)
    {
        $optionId = intval($optionId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "DELETE FROM tblproductconfigoptionssub WHERE configid = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$optionId]);
        $pdo->commit();
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
            throw new \Exception("Currency 'USD' Not Configured");
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

    public static function filterProductOptions($productOptions)
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

    public static function setConfigOptionPrice($optionSubId, $price, $currencyId)
    {
        $optionSubId = intval($optionSubId);
        $currencyId = intval($currencyId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT id FROM tblpricing WHERE type = 'configoptions' AND relid = ? AND currency = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$optionSubId, $currencyId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["id"]) && !empty($row["id"])) {
            $priceId = $row["id"];
            $pdo->beginTransaction();
            $query = "UPDATE tblpricing SET monthly = ? WHERE id = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$price, $priceId]);
            $pdo->commit();
        } else {
            $pdo = Manager::connection()->getPdo();
            $pdo->beginTransaction();
            $query = "INSERT INTO tblpricing (type, currency, relid, msetupfee, monthly) VALUES ('configoptions', ?, ?, 0, ?)";
            $statement = $pdo->prepare($query);
            $statement->execute([$currencyId, $optionSubId, $price]);
            $pdo->commit();
        }
    }

    public static function setProductPrice(int $productId, $price, int $currencyId)
    {
        $pricing = Capsule::table('tblpricing')->where('type', 'product')->where('relid', $productId)
            ->where('currency', $currencyId)->select('id')->first();

        if ($pricing->id) {
            Capsule::table('tblpricing')->where('id', $pricing->id)->update([
                'monthly' => $price
            ]);
        } else {
            Capsule::table('tblpricing')->insert([
                'type' => 'product',
                'currency' => $currencyId,
                'relid' => $productId,
                'monthly' => $price,
            ]);
        }
    }

    public static function getLastServiceId($userId)
    {
        $userId = intval($userId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT id FROM tblhosting WHERE userid = ? ORDER BY id DESC";
        $statement = $pdo->prepare($query);
        $statement->execute([$userId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["id"]) && !empty($row["id"])) {
            return $row["id"];
        } else {
            return false;
        }
    }

    public static function getProductIdByServiceId($serviceId)
    {
        $serviceId = intval($serviceId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT packageid FROM tblhosting WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$serviceId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["packageid"]) && !empty($row["packageid"])) {
            return $row["packageid"];
        } else {
            return false;
        }
    }

    public static function getProductIdByRemoteProductId($remoteProductId)
    {
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT id FROM tblproducts WHERE configoption1 = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$remoteProductId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (!isset($row["id"]) || empty($row["id"])) {
            return false;
        } else {
            return $row["id"];
        }
    }

    public static function getProductName($productId)
    {
        $productId = intval($productId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT name FROM tblproducts WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$productId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (!isset($row["name"]) || empty($row["name"])) {
            return false;
        }

        return $row["name"];
    }

    public static function isDeviceAssigned($deviceId)
    {
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT tblcustomfieldsvalues.id " . "FROM tblcustomfieldsvalues " . "INNER JOIN tblcustomfields " . "ON tblcustomfieldsvalues.fieldid = tblcustomfields.id " . "INNER JOIN tblproducts " . "ON tblcustomfields.relid = tblproducts.id " . "WHERE tblcustomfields.fieldname LIKE 'hivelocityDeviceId%' AND tblcustomfieldsvalues.value = ?";

        $statement = $pdo->prepare($query);
        $statement->execute([$deviceId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["id"]) && !empty($row["id"])) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAssignedDeviceId($serviceId)
    {
        $serviceId = intval($serviceId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT tblcustomfieldsvalues.value " . "FROM tblcustomfieldsvalues " . "INNER JOIN tblcustomfields " . "ON tblcustomfieldsvalues.fieldid = tblcustomfields.id " . "WHERE tblcustomfields.fieldname LIKE 'hivelocityDeviceId%' AND tblcustomfieldsvalues.relid = ?";

        $statement = $pdo->prepare($query);
        $statement->execute([$serviceId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["value"]) && !empty($row["value"])) {
            return $row["value"];
        } else {
            return false;
        }
    }

    public static function getServiceIdByAssignedDeviceId($deviceId)
    {
        $deviceId = intval($deviceId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT tblcustomfieldsvalues.relid " . "FROM tblcustomfieldsvalues " . "INNER JOIN tblcustomfields " . "ON tblcustomfieldsvalues.fieldid = tblcustomfields.id " . "WHERE tblcustomfields.fieldname LIKE 'hivelocityDeviceId%' AND tblcustomfieldsvalues.value = ?";

        $statement = $pdo->prepare($query);
        $statement->execute([$deviceId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["relid"]) && !empty($row["relid"])) {
            return $row["relid"];
        } else {
            return false;
        }
    }

    public static function getServiceDomain($serviceId)
    {
        $serviceId = intval($serviceId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT domain FROM tblhosting WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$serviceId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["domain"]) && !empty($row["domain"])) {
            return $row["domain"];
        } else {
            return false;
        }
    }

    public static function getUserIdByServiceId($serviceId)
    {
        $serviceId = intval($serviceId);

        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT userid FROM tblhosting WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$serviceId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["userid"]) && !empty($row["userid"])) {
            return $row["userid"];
        } else {
            return false;
        }
    }

    public static function getCurrencyId($currencyCode)
    {
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT id FROM tblcurrencies WHERE code = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$currencyCode]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["id"]) && !empty($row["id"])) {
            return $row["id"];
        } else {
            return false;
        }
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
        $pdo = Manager::connection()->getPdo();
        $pdo->beginTransaction();
        $query = "SELECT monthly FROM tblpricing WHERE type = 'product' AND relid = ? AND currency = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$productId, $currencyId]);
        $row = $statement->fetch();
        $pdo->commit();

        if (isset($row["monthly"])) {
            return $row["monthly"];
        } else {
            return false;
        }
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
