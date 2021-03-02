<?php

namespace HivelocityPricingTool\classes;
use Illuminate\Database\Capsule\Manager as Capsule;

class Helpers {
    static public function isNotificationEnabled() {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT value FROM tbladdonmodules WHERE module = 'HivelocityPricingTool' AND setting = 'priceNotification'";
        $statement  = $pdo->prepare($query);
        $statement->execute();
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["value"]) && $row["value"] == "on") {
            return true;
        } else {
            return false;
        }
    }
    
    static public function saveHivelocityProductPrice($hivelocityProductId, $hivelocityProductPrice) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query =  "INSERT INTO HivelocityProductPrices (hivelocityProductId, hivelocityProductPrice) VALUES (?,?) ON DUPLICATE KEY UPDATE hivelocityProductPrice = ?;";
        $statement = $pdo->prepare($query);
        $statement->execute([$hivelocityProductId, $hivelocityProductPrice, $hivelocityProductPrice]);
        $pdo->commit();
    }
    
    static public function getHivelocityProductPrice($hivelocityProductId) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT hivelocityProductPrice FROM HivelocityProductPrices WHERE hivelocityProductId = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$hivelocityProductId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["hivelocityProductPrice"])) {
            return $row["hivelocityProductPrice"];
        } else {
            return false;
        }
    }
    
    static public function saveHivelocityDeploymentCorrelation($whmcsServiceId, $hivelocityDeploymentId) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query =  "INSERT INTO HivelocityDeploymentCorrelation (whmcsServiceId, hivelocityDeploymentId) VALUES (?,?) ON DUPLICATE KEY UPDATE hivelocityDeploymentId = ?;";
        $statement = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId, $hivelocityDeploymentId, $hivelocityDeploymentId]);
        $pdo->commit();
    }
    
    static public function getHivelocityDeploymentCorrelation($whmcsServiceId) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT hivelocityDeploymentId FROM HivelocityDeploymentCorrelation WHERE whmcsServiceId = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["hivelocityDeploymentId"])) {
            return $row["hivelocityDeploymentId"];
        } else {
            return false;
        }
    }
    
    static public function saveHivelocityServiceCorrelation($whmcsServiceId, $hivelocityServiceId) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query =  "INSERT INTO HivelocityServiceCorrelation (whmcsServiceId, hivelocityServiceId) VALUES (?,?) ON DUPLICATE KEY UPDATE hivelocityServiceId = ?;";
        $statement = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId, $hivelocityServiceId, $hivelocityServiceId]);
        $pdo->commit();
    }
    
    static public function getHivelocityServiceCorrelation($whmcsServiceId) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT hivelocityServiceId FROM HivelocityServiceCorrelation WHERE whmcsServiceId = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["hivelocityServiceId"])) {
            return $row["hivelocityServiceId"];
        } else {
            return false;
        }
    }
    
    static public function saveHivelocityDeviceCorrelation($whmcsServiceId, $hivelocityDeviceId) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query =  "INSERT INTO HivelocityDeviceCorrelation (whmcsServiceId, hivelocityDevicetId) VALUES (?,?) ON DUPLICATE KEY UPDATE hivelocityDevicetId = ?;";
        $statement = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId, $hivelocityDeviceId, $hivelocityDeviceId]);
        $pdo->commit();
    }
    
    static public function getHivelocityDeviceCorrelation($whmcsServiceId) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT hivelocityDevicetId FROM HivelocityDeviceCorrelation WHERE whmcsServiceId = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["hivelocityDevicetId"])) {
            return $row["hivelocityDevicetId"];
        } else {
            return false;
        }
    }
    
    static public function getLocationName($locationId) {
        
        $temp = explode("-",$locationId);
        
        if(isset($temp[1])) {
            $locationId = $temp[1];
        } else {
            $locationId = $temp[0];
        }
        
        $locationArray = array(
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
        );
        
        $locationName = $locationArray[$locationId];
        
        if(empty($locationName)) {
            $locationName = $locationId;
        }
    
        return $locationName;
    }
    
    static public function getServerConfigByProductId($productId) {
        
        $productId  = intval($productId);
        
        $pdo        = Capsule::connection()->getPdo();
        
        $pdo->beginTransaction();
        $query      = "SELECT servergroup FROM tblproducts WHERE id = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$productId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["servergroup"]) && !empty($row["servergroup"])) {
            $serverGroupId = $row["servergroup"];
        } else {
            return false;
        }
        
        return self::getServerConfigByServerGroupId($serverGroupId);
    }
    
    static public function getServerConfigByServerGroupId($serverGroupId) {
        
        $serverGroupId  = intval($serverGroupId);
        
        $pdo        = Capsule::connection()->getPdo();
        
        $pdo->beginTransaction();
        $query      = "SELECT serverid FROM tblservergroupsrel WHERE groupid = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$serverGroupId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["serverid"]) && !empty($row["serverid"])) {
            $serverId = $row["serverid"];
        } else {
            return false;
        }
        
        $pdo->beginTransaction();
        $query      = "SELECT * FROM tblservers WHERE id = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$serverId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["id"]) && !empty($row["id"])) {
            return $row;
        } else {
            return false;
        }
    }
    
    static public function getProductCustomFieldId($productId) {
        
        $productId = intval($productId);
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query =  "SELECT id FROM tblcustomfields WHERE type = 'product' AND relid = '$productId' AND fieldname LIKE 'hivelocityDeviceId%'";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $row = $statement->fetch();
        $pdo->commit();
        
        if(!isset($row["id"]) || empty($row["id"])) {
            return false;
        }
        return $row["id"];
    }
    
    static public function addProductCustomField($productId) {
        
        $productId  = intval($productId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "INSERT INTO tblcustomfields (type, relid, fieldname, fieldtype, adminonly) VALUES ('product', $productId, 'hivelocityDeviceId|Server ID', 'text', 'on')";
        $statement  = $pdo->prepare($query);
        $statement->execute();
        $pdo->commit();
    }
    
    static public function getProductModule($productId) {
        
        $productId  = intval($productId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      =  "SELECT servertype FROM tblproducts WHERE id = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$productId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(!isset($row["servertype"]) || empty($row["servertype"])) {
            return false;
        }
        return $row["servertype"];
    }
    
    static public function getProductList() {
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT * FROM tblproducts WHERE servertype = 'Hivelocity'";
        $statement  = $pdo->prepare($query);
        $statement->execute();
        $rows       = $statement->fetchAll();
        $pdo->commit();
        
        return $rows;
    }
    
    static public function getConfigOptionsGroupId($productId) {
        
        $productId  = intval($productId);
        
        $name       = "Hivelocity - Product - ".$productId;
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT id FROM tblproductconfiggroups WHERE name = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$name]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(!isset($row["id"]) || empty($row["id"])) {
            return false;
        }
        return $row["id"];
    }
    
    static public function createConfigOptionsGroup($productId) {
        
        $productId = intval($productId);
        
        $name       = "Hivelocity - Product - ".$productId;
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "INSERT INTO tblproductconfiggroups (name) VALUES (?)";
        $statement  = $pdo->prepare($query);
        $statement->execute([$name]);
        $pdo->commit();
    }
    
    static public function getConfigOptionsLinkId($productId, $groupId) {
        
        $productId  = intval($productId);
        $groupId    = intval($groupId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT id FROM tblproductconfiglinks WHERE gid = ? AND pid = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$groupId, $productId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(!isset($row["id"]) || empty($row["id"])) {
            return false;
        }
        return $row["id"];
    }
    
    static public function createConfigOptionsLink($productId, $groupId) {
        
        $productId  = intval($productId);
        $groupId    = intval($groupId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "INSERT INTO tblproductconfiglinks (gid, pid) VALUES (?, ?)";
        $statement  = $pdo->prepare($query);
        $statement->execute([$groupId, $productId]);
        $pdo->commit();
    }
    
    static public function getConfigOptionId($groupId, $name) {
        
        $groupId  = intval($groupId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT id FROM tblproductconfigoptions WHERE gid = ? AND optionname = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$groupId, $name]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(!isset($row["id"]) || empty($row["id"])) {
            return false;
        }
        return $row["id"];
    }
    
    static public function createConfigOption($groupId, $name) {
        
        $groupId = intval($groupId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "INSERT INTO tblproductconfigoptions (gid, optionname, optiontype) VALUES (?, ?, 1)";
        $statement  = $pdo->prepare($query);
        $statement->execute([$groupId, $name]);
        $pdo->commit();
    }
    
    static public function getConfigOptionSubId($optionId, $name) {
        
        $optionId   = intval($optionId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT id FROM tblproductconfigoptionssub WHERE configid = ? AND optionname = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$optionId, $name]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(!isset($row["id"]) || empty($row["id"])) {
            return false;
        }
        return $row["id"];
    }
    
    static public function createConfigOptionSub($optionId, $name) {
        
        $optionId   = intval($optionId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "INSERT INTO tblproductconfigoptionssub (configid, optionname) VALUES (?, ?)";
        $statement  = $pdo->prepare($query);
        $statement->execute([$optionId, $name]);
        $pdo->commit();
    }
    
    static public function clearConfigOptionSub($optionId) {
        
        $optionId = intval($optionId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "DELETE FROM tblproductconfigoptionssub WHERE configid = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$optionId]);
        $pdo->commit();
    }
    
    static public function addConfigOptionPrice($optionSubId, $price, $currencyId) {
        
        $optionSubId    = intval($optionSubId);
        $currencyId     = intval($currencyId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "INSERT INTO tblpricing (type, currency, relid, msetupfee, monthly) VALUES ('configoptions', ?, ?, 0, ?)";
        $statement  = $pdo->prepare($query);
        $statement->execute([$currencyId, $optionSubId, $price]);
        $pdo->commit();
    }
    
    static public function setProductPrice($productId, $price, $currencyId) {
        
        $productId      = intval($productId);
        $currencyId     = intval($currencyId);
        
        $pdo            = Capsule::connection()->getPdo();
        
        $pdo->beginTransaction();
        $query          = "SELECT id FROM tblpricing WHERE type = 'product' AND relid = ? AND currency = ?";
        $statement      = $pdo->prepare($query);
        $statement->execute([$productId, $currencyId]);
        $row            = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["id"])) {
            
            $priceId    = $row["id"];
            $pdo->beginTransaction();
            $query      = "UPDATE tblpricing SET monthly = ? WHERE id = ?";
            $statement  = $pdo->prepare($query);
            $statement->execute([$price, $priceId]);
            $pdo->commit();
            
        } else {
            
            $pdo->beginTransaction();
            $query      = "INSERT INTO tblpricing (type, currency, relid, monthly) VALUES ('product', ?, ?, ?)";
            $statement  = $pdo->prepare($query);
            $statement->execute([$currencyId, $productId, $price]);
            $pdo->commit();
        }
    }
    
    static public function getLastServiceId($userId) {
        
        $userId     = intval($userId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT id FROM tblhosting WHERE userid = ? ORDER BY id DESC";
        $statement  = $pdo->prepare($query);
        $statement->execute([$userId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["id"]) && !empty($row["id"])) {
            return $row["id"];
        } else {
            return false;
        }
    }
    
    static public function getProductIdByServiceId($serviceId) {
        
        $serviceId  = intval($serviceId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT packageid FROM tblhosting WHERE id = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$serviceId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["packageid"]) && !empty($row["packageid"])) {
            return $row["packageid"];
        } else {
            return false;
        }
    }
    
    static public function isDeviceAssigned($deviceId) {
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT tblcustomfieldsvalues.id "
                    . "FROM tblcustomfieldsvalues "
                        . "INNER JOIN tblcustomfields "
                            . "ON tblcustomfieldsvalues.fieldid = tblcustomfields.id "
                        . "INNER JOIN tblproducts "
                            . "ON tblcustomfields.relid = tblproducts.id "
                        . "WHERE tblcustomfields.fieldname LIKE 'hivelocityDeviceId%' AND tblcustomfieldsvalues.value = ?";
        
        $statement  = $pdo->prepare($query);
        $statement->execute([$deviceId]);
        $row       = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["id"]) && !empty($row["id"])) {
            return true;
        } else {
            return false;
        }
    }
    
    static public function getAssignedDeviceId($serviceId) {
        
        $serviceId = intval($serviceId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT tblcustomfieldsvalues.value "
                    . "FROM tblcustomfieldsvalues "
                        . "INNER JOIN tblcustomfields "
                            . "ON tblcustomfieldsvalues.fieldid = tblcustomfields.id "
                        . "WHERE tblcustomfields.fieldname LIKE 'hivelocityDeviceId%' AND tblcustomfieldsvalues.relid = ?";
        
        $statement  = $pdo->prepare($query);
        $statement->execute([$serviceId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["value"]) && !empty($row["value"])) {
            return $row["value"];
        } else {
            return false;
        }
    }
    
    static public function getServiceIdByAssignedDeviceId($deviceId) {
        
        $deviceId = intval($deviceId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT tblcustomfieldsvalues.relid "
                    . "FROM tblcustomfieldsvalues "
                        . "INNER JOIN tblcustomfields "
                            . "ON tblcustomfieldsvalues.fieldid = tblcustomfields.id "
                        . "WHERE tblcustomfields.fieldname LIKE 'hivelocityDeviceId%' AND tblcustomfieldsvalues.value = ?";
        
        $statement  = $pdo->prepare($query);
        $statement->execute([$deviceId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["relid"]) && !empty($row["relid"])) {
            return $row["relid"];
        } else {
            return false;
        }
    }
    
    static public function getServiceDomain($serviceId) {
        $serviceId  = intval($serviceId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT domain FROM tblhosting WHERE id = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$serviceId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["domain"]) && !empty($row["domain"])) {
            return $row["domain"];
        } else {
            return false;
        }
    }
    
    static public function getUserIdByServiceId($serviceId) {
        
        $serviceId  = intval($serviceId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT userid FROM tblhosting WHERE id = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$serviceId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["userid"]) && !empty($row["userid"])) {
            return $row["userid"];
        } else {
            return false;
        }
    }
    
    static public function getCurrencyId($currencyCode) {
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT id FROM tblcurrencies WHERE code = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$currencyCode]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["id"]) && !empty($row["id"])) {
            return $row["id"];
        } else {
            return false;
        }
    }
    
    static public function getCurrencyRate($currencyCode) {
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT rate FROM tblcurrencies WHERE code = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$currencyCode]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["rate"]) && !empty($row["rate"])) {
            return $row["rate"];
        } else {
            return false;
        }
    }
    
    static public function getCurrencyList() {
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT * FROM tblcurrencies";
        $statement  = $pdo->prepare($query);
        $statement->execute();
        $rows       = $statement->fetchAll();
        $pdo->commit();
        
        return $rows;
    }
    
    static public function getProductPrice($productId, $currencyId) {
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT monthly FROM tblpricing WHERE type = 'product' AND relid = ? AND currency = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$productId, $currencyId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["monthly"])) {
            return $row["monthly"];
        } else {
            return false;
        }
    }
    
}
