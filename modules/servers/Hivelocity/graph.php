<?php

require_once '../../../init.php';
require_once 'Autoloader.php';

try {
    \Hivelocity\classes\Graph::getGraph($params);
} catch (Exception $e) {}
