<?php

namespace HivelocityPricingTool\classes;

use Exception;
use Throwable;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Api
{
    private static string $apiUrl;
    private static string $apiKey;

    public static function setApiDetails($apiUrl, $apiKey)
    {
        $apiUrl = str_replace("DOT", ".", $apiUrl);

        self::$apiUrl = "https://" . $apiUrl . "/api/v2";
        self::$apiKey = $apiKey;
    }

    public static function sendRequest($resource, $httpMethod = 'GET', $postFields = [], $postInQuery = false)
    {
        $apiKey = self::$apiKey;
        $url = self::$apiUrl . $resource;

        $data = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => '*/*',
                'Accept-Encoding' => '',
                'X-API-KEY' => $apiKey,
                'Referer' => 'WHMCS',
            ],
        ];

        if (!empty($postFields)) {
            if ($httpMethod == "POST" && $postInQuery) {
                $data['query'] = $postFields;
            } else {
                $data['body'] = json_encode($postFields);
            }
        }

        try {
            $request = (new Client)->request($httpMethod, $url, $data);

            $response = json_decode($request->getBody(), true);

            if (isset($response['message']) && isset($response['code']) && $response['code'] != 201) {
                if (is_array($response['message'])) {
                    $message = implode(' ', $response['message']);
                } else {
                    $message = $response['message'];
                }

                throw new Exception($message);
            }

            if (isset($response['description']) && isset($response['code']) && $response['code'] > 201) {
                if (is_array($response['description'])) {
                    $message = implode(' ', $response['description']);
                } else {
                    $message = $response['description'];
                }

                throw new Exception($message);
            }

            if (isset($response['schema_errors'])) {
                $fullMessage = '';
                foreach ($response['schema_errors'] as $field => $error) {
                    foreach ($error as $msg) {
                        if (is_array($msg)) {
                            $message = implode(' ', $msg);
                        } else {
                            $message = $msg;
                        }
                        $message = $field . ': ' . $message;
                    }
                    $fullMessage .= $message . ' ';
                }
                throw new Exception($fullMessage);
            }

            if (isset($response['errors'])) {
                $fullMessage = '';
                foreach ($response['errors'] as $field => $error) {
                    if (is_array($error)) {
                        $message = $field . ': ' . implode(' ', $error);
                        $fullMessage .= $message . " ";
                    } else {
                        $message = $error;
                        $fullMessage .= $message . ' ';
                    }
                }
                throw new Exception($fullMessage);
            }

            return $response;

        }catch (ClientException|Throwable $e){
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public static function getProductList()
    {
        $resource = "/inventory/product";
        $response = self::sendRequest($resource);

        return $response;
    }

    public static function getProductDetails($productId)
    {
        $resource = "/inventory/product/$productId";
        $response = self::sendRequest($resource);

        return $response;
    }

    public static function getProductOptions($productId)
    {
        $resource = "/product/$productId/options?groupBy=upgrade";
        $response = self::sendRequest($resource);

        return $response;
    }

    public static function getProductOS($productId)
    {
        $resource = "/product/$productId/operating-systems";
        $response = self::sendRequest($resource);

        return $response;
    }

    public static function getBillingInfoList()
    {
        $resource = "/billing-info/";
        $response = self::sendRequest($resource);

        return $response;
    }

    public static function createDeployment($deploymentName)
    {
        $resource = "/deploy/";

        $postFields = [
            "deploymentName" => $deploymentName,
        ];

        $response = self::sendRequest($resource, "POST", $postFields, true);

        return $response;
    }

    public static function getDeploymentList()
    {
        $resource = "/deploy/";

        $response = self::sendRequest($resource);

        return $response;
    }

    public static function getDeploymentDetails($deploymentId)
    {
        $resource = "/deploy/$deploymentId";

        $response = self::sendRequest($resource);

        return $response;
    }

    public static function configureDeployment($deploymentId, $productId, $locationId, $osId, $panelId, $hostName,
        $billingPeriod
    )
    {
        $resource = "/deploy/$deploymentId";

        $postFields = [
            "locationCode" => $locationId,
            "billingPeriod" => $billingPeriod,
            "operatingSystem" => $osId,
            "hostnames" => [$hostName],
            "productId" => $productId,
        ];

        if (!empty($panelId)) {
            $postFields["options"] = [$panelId];
        }

        $response = self::sendRequest($resource, "PUT", $postFields);

        return $response;
    }

    public static function executeDeployment($deploymentId, $billingInfoId)
    {
        $resource = "/deploy/$deploymentId";

        $postFields = [
            "billingInfo" => $billingInfoId,
        ];

        $response = self::sendRequest($resource, "POST", $postFields);

        return $response;
    }

    public static function getInvoiceList()
    {
        $resource = "/invoice/";

        $response = self::sendRequest($resource);

        return $response;
    }

    public static function getOrderList()
    {
        $resource = "/order/";

        $response = self::sendRequest($resource);

        return $response;
    }

    public static function getServiceList($orderId)
    {
        $resource = "/service/?orderId=$orderId";

        $response = self::sendRequest($resource);

        return $response;
    }

    public static function getDeviceList()
    {
        $resource = "/device/";

        $response = self::sendRequest($resource);

        return $response;
    }

    public static function getDeviceDetails($deviceId)
    {
        $resource = "/device/$deviceId";
        $response = self::sendRequest($resource);

        return $response;
    }

    public static function cancelDevice($deviceId)
    {
        $resource = "/cancellation/cancellation";

        $postFields = [
            "deviceId" => $deviceId,
        ];

        $response = self::sendRequest($resource, "POST", $postFields);

        return $response;
    }

    public static function getGraph($deviceId, $period = "day", $start = null, $end = null)
    {
        $resource = "/bandwidth/device/$deviceId/image";

        $postFields = [
            "period" => $period,
            "start" => $start,
            "end" => $end,
            "interface" => "eth0",
        ];

        $response = self::sendRequest($resource, "POST", $postFields, true);

        return $response;
    }

    public static function getBandwidthDetails($deviceId, $period = "day", $start = null, $end = null)
    {
        $resource = "/bandwidth/device/$deviceId";

        $postFields = [
            "period" => $period,
            "start" => $start,
            "end" => $end,
            "interface" => "eth0",
        ];

        $response = self::sendRequest($resource, "POST", $postFields, true);

        return $response;
    }

    public static function executePowerAction($deviceId, $powerAction)
    {
        $resource = "/device/$deviceId/power";

        $postFields = [
            "action" => $powerAction,
        ];

        $response = self::sendRequest($resource, "POST", $postFields, true);

        return $response;
    }

    public static function bootDevice($deviceId)
    {
        return self::executePowerAction($deviceId, "boot");
    }

    public static function rebootDevice($deviceId)
    {
        return self::executePowerAction($deviceId, "reboot");
    }

    public static function shutdownDevice($deviceId)
    {
        return self::executePowerAction($deviceId, "shutdown");
    }
}
