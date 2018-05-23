<?php
  namespace Metatavu\Lyyti\Api;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  use \Metatavu\Lyyti\Settings\Settings;

  require_once( __DIR__ . '/../settings/settings.php');

  if (!class_exists( '\Metatavu\Lyyti\Api\ApiClient' ) ) {
    
    /**
     * API Client for Lyyti API
     */
    class ApiClient {

      /**
       * Lists events
       * 
       * @see https://lyyti.readme.io/docs/events
       * @return Array event list 
       */
      public function listEvents($parameters) {
        return $this->apiCall("events", $parameters);
      }

      /**
       * Returns whether API result is an error
       * 
       * @return boolean whether API result is an error
       */
      public function isError($result) {
        return !!$result["error"];
      }

      /**
       * Makes an API call. Modified version of Lyyti's PHP example
       * 
       * @see https://lyyti.readme.io/docs/example-api-call-function
       * @return Array response
       */
      private function apiCall($path, $query, $method = 'GET', $payload = null) {
        $callString = add_query_arg($query, "$path");
        $publicKey = $this->getPublicKey();
        $privateKey = $this->getPrivateKey();
        $apiUrl = $this->getApiUrl();
        $timestamp = time();
        $signature = hash_hmac('sha256', base64_encode("$publicKey,$timestamp,$callString"), $privateKey);

        $headers = [
          'Accept: application/json; charset=utf-8',
          "Authorization: LYYTI-API-V2 public_key=$publicKey,timestamp=$timestamp,signature=$signature"
        ];

        $curl = curl_init("$apiUrl/$callString");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($method != 'GET' && isset($payload)) {
          if ($method == 'PATCH') {
            $headers[] = 'Content-Type: application/merge-patch+json';
          } else {
            $headers[] = 'Content-Type: application/json; charset=utf-8';
          }
          
          if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
          } else {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
          }

          curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result_json = curl_exec($curl);

        if ($curl_errno = curl_errno($curl)) {
          return ['error' => '[' . $curl_errno . '] ' . curl_strerror($curl_errno)];
        }

        curl_close($curl);

        return json_decode($result_json, true);
      }

      /**
       * Returns API URL
       * 
       * @return string API URL
       */
      private function getApiUrl() {
        return Settings::getValue("api-url");
      }

      /**
       * Returns public key
       * 
       * @return string public key
       */
      private function getPublicKey() {
        return Settings::getValue("public-key");
      }

      /**
       * Returns private key
       * 
       * @return string private key
       */
      private function getPrivateKey() {
        return Settings::getValue("private-key");
      }

    }
  }
  
?>