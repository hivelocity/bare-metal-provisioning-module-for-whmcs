<?php

namespace Hivelocity\classes;
use Illuminate\Database\Capsule\Manager as Capsule;

class Helpers {
    
    static public function debugLog($desc, $data) {
        logmodulecall("Hivelocity Debug Log", $desc, $data, "", "");
    }
    
    static public function maintenanceDatabase() {
    
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query =  " CREATE TABLE IF NOT EXISTS HivelocityProductPrices("
                . "     hivelocityProductId int PRIMARY KEY NOT NULL, "
                . "     hivelocityProductPrice DECIMAL(10,3) NOT NULL "
                . " );";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $pdo->commit();
        
        $pdo->beginTransaction();
        $query =  " CREATE TABLE IF NOT EXISTS HivelocityDeploymentCorrelation("
                . "     whmcsServiceId int PRIMARY KEY NOT NULL, "
                . "     hivelocityDeploymentId int NOT NULL "
                . " );";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $pdo->commit();
        
        $pdo->beginTransaction();
        $query =  " CREATE TABLE IF NOT EXISTS HivelocityOrderCorrelation("
                . "     whmcsServiceId int PRIMARY KEY NOT NULL, "
                . "     hivelocityOrderId int NOT NULL "
                . " );";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $pdo->commit();
        
        
        $pdo->beginTransaction();
        $query =  " CREATE TABLE IF NOT EXISTS HivelocityServiceCorrelation("
                . "     whmcsServiceId int PRIMARY KEY NOT NULL, "
                . "     hivelocityServiceId int NOT NULL "
                . " );";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $pdo->commit();
        
        $pdo->beginTransaction();
        $query =  " CREATE TABLE IF NOT EXISTS HivelocityDeviceCorrelation("
                . "     whmcsServiceId int PRIMARY KEY NOT NULL, "
                . "     hivelocityDeviceId int NOT NULL "
                . " );";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $pdo->commit();
        
        $pdo->beginTransaction();
        $query =  " CREATE TABLE IF NOT EXISTS HivelocityDomainCorrelation("
                . "     hivelocityDomainId int PRIMARY KEY NOT NULL, "
                . "     whmcsUserId int NOT NULL, "
                . "     whmcsServiceId int NOT NULL "
                . " );";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $pdo->commit();
        
        
        $pdo->beginTransaction();
        $query =  "SELECT id FROM tblemailtemplates WHERE name='Hivelocity Product Price Change'";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $row = $statement->fetch();
        $pdo->commit();
        
        if(empty($row['id'])) {
            $pdo->beginTransaction();
            $query =  " INSERT IGNORE INTO tblemailtemplates"
                    . " (type, name, subject, message, custom)"
                    . " VALUES ('admin', 'Hivelocity Product Price Change', 'Hivelocity Product Price Change', '<p>The price of the product {\$hivelocityProductId} has changed from {\$oldPrice} to {\$newPrice}.</p>',1);";
            $statement = $pdo->prepare($query);
            $statement->execute();
            $pdo->commit();
        }
    }
    
    static public function isTwentyOne() {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT value FROM tblconfiguration WHERE setting = 'Template'";
        $statement  = $pdo->prepare($query);
        $statement->execute();
        $row        = $statement->fetch();
        $pdo->commit();
        
        if($row["value"] == "twenty-one") {
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
        
        if(isset($row["hivelocityDeploymentId"]) && !empty($row["hivelocityDeploymentId"])) {
            return $row["hivelocityDeploymentId"];
        } else {
            return false;
        }
    }
    
    static public function deleteHivelocityDeploymentCorrelationByDeploymentId($hivelocityDeploymentId) {
        Capsule::table('HivelocityDeploymentCorrelation')
        ->where('hivelocityDeploymentId', '=', $hivelocityDeploymentId)
        ->delete();
    }

    static public function saveHivelocityOrderCorrelation($whmcsServiceId, $hivelocityOrderId) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query =  "INSERT INTO HivelocityOrderCorrelation (whmcsServiceId, hivelocityOrderId) VALUES (?,?) ON DUPLICATE KEY UPDATE hivelocityOrderId = ?;";
        $statement = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId, $hivelocityOrderId, $hivelocityOrderId]);
        $pdo->commit();
    }
    
    static public function getHivelocityOrderCorrelation($whmcsServiceId) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT hivelocityOrderId FROM HivelocityOrderCorrelation WHERE whmcsServiceId = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["hivelocityOrderId"]) && !empty($row["hivelocityOrderId"])) {
            return $row["hivelocityOrderId"];
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
    
    static public function saveHivelocityDomainCorrelation($whmcsServiceId, $whmcsUserId, $hivelocityDomainId) {
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      =  "INSERT INTO HivelocityDomainCorrelation (whmcsServiceId, whmcsUserId, hivelocityDomainId) VALUES (?,?,?) ON DUPLICATE KEY UPDATE whmcsServiceId = ?, whmcsUserId = ?;";
        $statement  = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId, $whmcsUserId, $hivelocityDomainId, $whmcsServiceId, $whmcsUserId]);
        $pdo->commit();
    }
    
    static public function getHivelocityDomainCorrelationByServiceId($whmcsServiceId) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT hivelocityDomainId FROM HivelocityDomainCorrelation WHERE whmcsServiceId = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$whmcsServiceId]);
        $rows       = $statement->fetchAll();
        $pdo->commit();
        
        $hivelocityDomainList = array();
        
        foreach($rows as $row) {
            $hivelocityDomainList[] = $row["hivelocityDomainId"];
        }
        
        if(empty($hivelocityDomainList)) {
            return false;
        } else {
            return $hivelocityDomainList;
        }
    }
    
    static public function getHivelocityDomainCorrelationByUserId($whmcsUserId) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT hivelocityDomainId FROM HivelocityDomainCorrelation WHERE whmcsUserId = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$whmcsUserId]);
        $rows       = $statement->fetchAll();
        $pdo->commit();
        
        $hivelocityDomainList = array();
        
        foreach($rows as $row) {
            $hivelocityDomainList[] = $row["hivelocityDomainId"];
        }
        
        if(empty($hivelocityDomainList)) {
            return false;
        } else {
            return $hivelocityDomainList;
        }
    }
    
    static public function getHivelocityDomainCorrelationByDomainId($hivelocityDomainId) {
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT * FROM HivelocityDomainCorrelation WHERE hivelocityDomainId = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$hivelocityDomainId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["hivelocityDomainId"])) {
            return $row;
        } else {
            return false;
        }
    }
    
    static public function removeHivelocityDomainCorrelation($hivelocityDomainId) {
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      =  "DELETE IGNORE FROM HivelocityDomainCorrelation WHERE hivelocityDomainId = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$hivelocityDomainId]);
        $pdo->commit();
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
        $query      = "INSERT INTO tblcustomfields (type, relid, fieldname, fieldtype, adminonly) VALUES ('product', $productId, 'hivelocityDeviceId|Device ID', 'text', 'on')";
        $statement  = $pdo->prepare($query);
        $statement->execute();
        $pdo->commit();
    }
    
    static public function getProductModule($productId) {
        
        $productId = intval($productId);
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query =  "SELECT servertype FROM tblproducts WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$productId]);
        $row = $statement->fetch();
        $pdo->commit();
        
        if(!isset($row["servertype"]) || empty($row["servertype"])) {
            return false;
        }
        return $row["servertype"];
    }
    
    static public function getProductName($productId) {
        
        $productId = intval($productId);
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query =  "SELECT name FROM tblproducts WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$productId]);
        $row = $statement->fetch();
        $pdo->commit();
        
        if(!isset($row["name"]) || empty($row["name"])) {
            return false;
        }
        return $row["name"];
    }
    
    static public function getRemoteProductIdByProductId($productId) {
        
        $productId = intval($productId);
        
        $pdo = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query =  "SELECT configoption1 FROM tblproducts WHERE id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$productId]);
        $row = $statement->fetch();
        $pdo->commit();
        
        if(!isset($row["configoption1"]) || empty($row["configoption1"])) {
            return false;
        }
        return $row["configoption1"];
    }
    
    static public function getConfigOptionsGroupId($productId) {
        
        $productId  = intval($productId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT tblproductconfiggroups.id FROM tblproductconfiggroups INNER JOIN tblproductconfiglinks ON tblproductconfiggroups.id = tblproductconfiglinks.gid WHERE tblproductconfiggroups.name LIKE '%Hivelocity%' AND tblproductconfiglinks.pid = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$productId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(!isset($row["id"]) || empty($row["id"])) {
            return false;
        }
        return $row["id"];
    }
    
    static public function getConfigOptionsGroupName($configOptionsGroupId) {
        
        $configOptionsGroupId   = intval($configOptionsGroupId);
        
        $pdo                    = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query                  = "SELECT name FROM tblproductconfiggroups  WHERE id = ?";
        $statement              = $pdo->prepare($query);
        $statement->execute([$configOptionsGroupId]);
        $row                    = $statement->fetch();
        $pdo->commit();
        
        if(!isset($row["name"]) || empty($row["name"])) {
            return false;
        }
        return $row["name"];
    }
    
    static public function createConfigOptionsGroup($productId) {
        
        $productId      = intval($productId);
        
        $productName    = self::getProductName($productId);
        $productName    = htmlspecialchars_decode($productName, ENT_QUOTES);
        
        $name           = "Configurable options for $productName product - Auto generated by module Hivelocity Bare-Metal";
        $name           = htmlspecialchars($name, ENT_QUOTES);
        
        $pdo            = Capsule::connection()->getPdo();
        
        $pdo->beginTransaction();
        $query          = "INSERT INTO tblproductconfiggroups (name) VALUES (?)";
        $statement      = $pdo->prepare($query);
        $statement->execute([$name]);
        $pdo->commit();
        
        $pdo->beginTransaction();
        $query          = "SELECT id FROM tblproductconfiggroups WHERE name = ?";
        $statement      = $pdo->prepare($query);
        $statement->execute([$name]);
        $row            = $statement->fetch();
        $pdo->commit();
        
        if(!isset($row["id"]) || empty($row["id"])) {
            return false;
        }
        return $row["id"];
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

    static public function getConfigOptionList($configOptionGroupId) {
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT * FROM tblproductconfigoptions WHERE gid = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$configOptionGroupId]);
        $rows       = $statement->fetchAll();
        $pdo->commit();
        
        return $rows;
    }
    
    static public function getConfigOptionId($groupId, $name) {
        
        $groupId    = intval($groupId);
        $name       = htmlspecialchars($name, ENT_QUOTES);
        
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
        
        $groupId    = intval($groupId);
        $name       = htmlspecialchars($name, ENT_QUOTES);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "INSERT INTO tblproductconfigoptions (gid, optionname, optiontype) VALUES (?, ?, 1)";
        $statement  = $pdo->prepare($query);
        $statement->execute([$groupId, $name]);
        $pdo->commit();
    }

    static public function hideConfigOption($configOptionId) {
        
        $productId  = intval($productId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "UPDATE tblproductconfigoptions SET hidden = 1 WHERE id = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$configOptionId]);
        $pdo->commit();
    }
    
    static public function unHideConfigOption($configOptionId) {
        
        $productId  = intval($productId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "UPDATE tblproductconfigoptions SET hidden = 0 WHERE id = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$configOptionId]);
        $pdo->commit();
    }
    
    static public function getConfigOptionSubId($optionId, $name) {
        
        $optionId   = intval($optionId);
        $name       = htmlspecialchars($name, ENT_QUOTES);
        
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
    
    static public function getConfigOptionSubList($optionId) {
        
        $optionId   = intval($optionId);
        $name       = htmlspecialchars($name, ENT_QUOTES);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT * FROM tblproductconfigoptionssub WHERE configid = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$optionId]);
        $rows       = $statement->fetchAll();
        $pdo->commit();
        
        
        return $rows;
    }
    
    static public function createConfigOptionSub($optionId, $name) {
        
        $optionId   = intval($optionId);
        $name       = htmlspecialchars($name, ENT_QUOTES);
        
        
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

    static public function hideConfigOptionSub($configOptionSubId) {
        
        $productId  = intval($productId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "UPDATE tblproductconfigoptionssub SET hidden = 1 WHERE id = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$configOptionSubId]);
        $pdo->commit();
    }
    
    static public function unHideConfigOptionSub($configOptionSubId) {
        
        $productId  = intval($productId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "UPDATE tblproductconfigoptionssub SET hidden = 0 WHERE id = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$configOptionSubId]);
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

    static public function setConfigOptionPrice($optionSubId, $price, $currencyId) {
        
        $optionSubId    = intval($optionSubId);
        $currencyId     = intval($currencyId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT id FROM tblpricing WHERE type = 'configoptions' AND relid = ? AND currency = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$optionSubId, $currencyId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["id"]) && !empty($row["id"])) {
            
            $priceId    = $row["id"];
            $pdo->beginTransaction();
            $query      = "UPDATE tblpricing SET monthly = ? WHERE id = ?";
            $statement  = $pdo->prepare($query);
            $statement->execute([$price, $priceId]);
            $pdo->commit();
            
        } else {
            
            $pdo        = Capsule::connection()->getPdo();
            $pdo->beginTransaction();
            $query      = "INSERT INTO tblpricing (type, currency, relid, msetupfee, monthly) VALUES ('configoptions', ?, ?, 0, ?)";
            $statement  = $pdo->prepare($query);
            $statement->execute([$currencyId, $optionSubId, $price]);
            $pdo->commit();
        }
    }
    
    static public function getFirstServiceId($userId) {
        
        $userId     = intval($userId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT id FROM tblhosting WHERE userid = ? ORDER BY domain ASC";
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
    
    static public function isHivelocityService($serviceId) {
        
        $serviceId  = intval($serviceId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT tblproducts.servertype FROM tblhosting INNER JOIN tblproducts ON tblhosting.packageid = tblproducts.id WHERE tblhosting.id = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$serviceId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["servertype"]) && $row["servertype"] == "Hivelocity") {
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
    
    static public function assignDevice($serviceId, $deviceId) {
        
        $productId      = self::getProductIdByServiceId($serviceId);
        $customFieldId  = self::getProductCustomFieldId($productId);
        
        $pdo        = Capsule::connection()->getPdo();
        
        $pdo->beginTransaction();
        $query      = "SELECT tblcustomfieldsvalues.id "
                    . "FROM tblcustomfieldsvalues "
                        . "INNER JOIN tblcustomfields "
                            . "ON tblcustomfieldsvalues.fieldid = tblcustomfields.id "
                        . "WHERE tblcustomfields.fieldname LIKE 'hivelocityDeviceId%' AND tblcustomfieldsvalues.relid = ?";
        
        $statement  = $pdo->prepare($query);
        $statement->execute([$serviceId]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["id"]) && !empty($row["id"])) {
            
            $customFieldValueId = $row["id"];
            
            $pdo->beginTransaction();
            $query      = "UPDATE tblcustomfieldsvalues SET value = ? WHERE id = ?";
            $statement  = $pdo->prepare($query);
            $statement->execute([$deviceId, $customFieldValueId]);
            $pdo->commit();
            
        } else {
            
            $pdo->beginTransaction();
            $query      = "INSERT INTO tblcustomfieldsvalues (fieldid, relid, value) VALUES (?, ?, ?)";
            $statement  = $pdo->prepare($query);
            $statement->execute([$customFieldId, $serviceId, $deviceId]);
            $pdo->commit();
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
    
    static public function getServiceIdList($serverId) {
        
        $serverId  = intval($serverId);
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT tblhosting.id FROM tblhosting INNER JOIN tblproducts ON tblhosting.packageid = tblproducts.id WHERE tblproducts.servertype = 'Hivelocity' AND server = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$serverId]);
        $rows       = $statement->fetchAll();
        $pdo->commit();
        
        $serviceIdList = array();
        
        foreach($rows as $row) {
            $serviceIdList[] = $row["id"];
        }
        
        return $serviceIdList;
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
    
    static public function getServiceIdByDomain($domain) {
        
        
        $pdo        = Capsule::connection()->getPdo();
        $pdo->beginTransaction();
        $query      = "SELECT id FROM tblhosting WHERE domain = ?";
        $statement  = $pdo->prepare($query);
        $statement->execute([$domain]);
        $row        = $statement->fetch();
        $pdo->commit();
        
        if(isset($row["id"]) && !empty($row["id"])) {
            return $row["id"];
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
    
    static public function filterProductOptions($productOptions) {
        
        $expectedOptions = array(
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
        );
        
        $filteredOptions = array();
        
        foreach($expectedOptions as $optionName) {
            if(isset($productOptions[$optionName]) && !empty($productOptions[$optionName])) {
                $filteredOptions[$optionName] = $productOptions[$optionName];
            }
        }
        
        return $filteredOptions;
    }
    
    static public function expandIp6($ip){
        $hex = bin2hex(inet_pton($ip));
        return implode(':', str_split($hex, 4));
    }
}
