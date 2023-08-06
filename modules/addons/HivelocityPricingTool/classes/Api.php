<?php

namespace HivelocityPricingTool\classes;

use Exception;

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

        $ch = curl_init();

        if (!empty($postFields)) {
            if ($httpMethod == "POST" && $postInQuery) {
                $postQuery = http_build_query($postFields);
                $url = $url . "?" . $postQuery;
            } else {
                $postJson = json_encode($postFields);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postJson);
            }
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $httpMethod);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "User-Agent: PostmanRuntime/7.26.8",
            "Accept: */*",
            "Accept-Encoding: ''",
            "X-API-KEY: $apiKey",
            "Referer: WHMCS"
        ]);

        $response = curl_exec($ch);
        $cUrlError = curl_error($ch);
        curl_close($ch);

        if (1) {
            if ($cUrlError) {
                $response = $cUrlError;
            }

            $action = "Hivelocity API Call";
            $request = [
                "Resource" => $resource,
                "Method" => $httpMethod,
                "Fields" => !empty($postFields) ? $postFields : "",
                "Json" => !empty($postJson) ? $postJson : "",
                "Query" => !empty($postQuery) ? $postQuery : "",
            ];
        }

        if ($cUrlError) {
            throw new Exception($cUrlError);
        }

        $rawResponse = $response;
        if (!empty($response)) {
            $response = json_decode($response, true);

            if (json_last_error() != JSON_ERROR_NONE) {
                throw new Exception("API response is invalid. " . $rawResponse);
            }

            if (isset($response["message"]) && isset($response["code"]) && $response["code"] != 201) {
                if (is_array($response["message"])) {
                    $message = implode(" ", $response["message"]);
                } else {
                    $message = $response["message"];
                }

                throw new Exception($message);
            }

            if (isset($response["description"]) && isset($response["code"]) && $response["code"] > 201) {
                if (is_array($response["description"])) {
                    $message = implode(" ", $response["description"]);
                } else {
                    $message = $response["description"];
                }

                throw new Exception($message);
            }

            if (isset($response["schema_errors"])) {
                $fullMessage = "";
                foreach ($response["schema_errors"] as $field => $error) {
                    foreach ($error as $msg) {
                        if (is_array($msg)) {
                            $message = implode(" ", $msg);
                        } else {
                            $message = $msg;
                        }
                        $message = $field . ": " . $message;
                    }
                    $fullMessage .= $message . " ";
                }
                throw new Exception($fullMessage);
            }

            if (isset($response["errors"])) {
                $fullMessage = "";
                foreach ($response["errors"] as $field => $error) {
                    if (is_array($error)) {
                        $message = $field . ": " . implode(" ", $error);
                        $fullMessage .= $message . " ";
                    } else {
                        $message = $error;
                        $fullMessage .= $message . " ";
                    }
                }
                throw new Exception($fullMessage);
            }
        } else {
            throw new Exception("API response is invalid.");
        }

        return $response;
    }

    public static function getProductList()
    {
        $resource = "/inventory/product";

        return self::sendRequest($resource);
    }

    public static function getProductDetails($productId)
    {
        $resource = "/inventory/product/$productId";

        return self::sendRequest($resource);
    }

    public static function getProductOptions($productId)
    {
        $resource = "/product/$productId/options?groupBy=upgrade";

        return self::sendRequest($resource);
    }

    public static function getProductOS($productId)
    {
        $resource = "/product/$productId/operating-systems";

        return self::sendRequest($resource);
    }

    public static function getBillingInfoList()
    {
        $resource = "/billing-info/";

        return self::sendRequest($resource);
    }

    public static function executePowerAction($deviceId, $powerAction)
    {
        $resource = "/device/$deviceId/power";

        $postFields = [
            "action" => $powerAction,
        ];

        return self::sendRequest($resource, "POST", $postFields, true);
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
