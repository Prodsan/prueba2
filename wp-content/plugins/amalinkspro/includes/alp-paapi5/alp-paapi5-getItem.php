<?php

/**
 * Copyright 2019 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

/*
 * ProductAdvertisingAPI
 *
 * https://webservices.amazon.com/paapi5/documentation/index.html
 */

/*
 * This sample code snippet is for ProductAdvertisingAPI 5.0's GetItems API
 *
 * For more details, refer: https://webservices.amazon.com/paapi5/documentation/get-items.html
 */

use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\api\DefaultApi;
use Amazon\ProductAdvertisingAPI\v1\ApiException;
use Amazon\ProductAdvertisingAPI\v1\Configuration;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\GetItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\GetItemsResource;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\PartnerType;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\ProductAdvertisingAPIClientException;

require_once(__DIR__ . '/paapi5-php-sdk/vendor/autoload.php'); // change path as needed
// fixes bug with Call to undefined function GuzzleHttp\choose_handler() 
// require_once(__DIR__ . '/paapi5-php-sdk/vendor/guzzlehttp/guzzle/src/functions.php');
// require_once(__DIR__ . '/paapi5-php-sdk/vendor/guzzlehttp/psr7/src/functions.php');
// require_once(__DIR__ . '/paapi5-php-sdk/vendor/guzzlehttp/promises/src/functions.php');

if ( ! function_exists( 'GuzzleHttp\choose_handler' ) )
    require_once(__DIR__ . '/paapi5-php-sdk/vendor/guzzlehttp/guzzle/src/functions_include.php');

if ( ! function_exists( '\GuzzleHttp\Psr7\build_query' ) )
    require_once(__DIR__ . '/paapi5-php-sdk/vendor/guzzlehttp/psr7/src/functions_include.php');

if ( ! function_exists( '\Promise\promise_for' ) )
    require_once(__DIR__ . '/paapi5-php-sdk/vendor/guzzlehttp/promises/src/functions_include.php');



/**
 * Returns the array of items mapped to ASIN
 *
 * @param array $items Items value.
 *
 * @return array of \Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item mapped to ASIN.
 */
// function parseResponse($items)
// {
//     $mappedResponse = array();
//     foreach ($items as $item) {
//         $mappedResponse[$item->getASIN()] = $item;
//     }
//     return $mappedResponse;
// }

function alp_api5_getItems( $asins, $aff_id )
{
    $config = new Configuration();

    /*
     * Add your credentials
     * Please add your access key here
     */

    // get our amazon api keys and affiliate id
    $amazonKeysInfo = alp_paapi5_get_amazon_keys();

    $config->setAccessKey( $amazonKeysInfo['aws_access_key_id'] );
    # Please add your secret key here
    $config->setSecretKey( $amazonKeysInfo['aws_secret_key'] );


    if ( $aff_id && $aff_id !== '' ) {
        $partnerTag = $aff_id;
    }
    else {
        $partnerTag = $amazonKeysInfo['affiliate_id'];
    }



    /*
     * PAAPI host and region to which you want to send request
     * For more details refer: https://webservices.amazon.com/paapi5/documentation/common-request-parameters.html#host-and-region
     */

    // Set our new api5 endpoint and region
    $endpoint = alp_paapi5_get_endpoint();

    $config->setHost( $endpoint['endpoint'] );
    $config->setRegion( $endpoint['region'] );

    $apiInstance = new DefaultApi(
    /*
     * If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
     * This is optional, `GuzzleHttp\Client` will be used as default.
     */
        new GuzzleHttp\Client(), $config);

    # Request initialization

    # Choose item id(s)

    
    $itemIds = $asins;

    /*
     * Choose resources you want from GetItemsResource enum
     * For more details, refer: https://webservices.amazon.com/paapi5/documentation/get-items.html#resources-parameter
     */
    $resources = array(
        GetItemsResource::ITEM_INFOTITLE,
        GetItemsResource::ITEM_INFOMANUFACTURE_INFO,
        GetItemsResource::OFFERSLISTINGSPRICE,
        GetItemsResource::IMAGESPRIMARYLARGE,
        GetItemsResource::IMAGESPRIMARYMEDIUM,
        GetItemsResource::IMAGESPRIMARYSMALL,
        GetItemsResource::IMAGESVARIANTSSMALL,
        GetItemsResource::IMAGESVARIANTSMEDIUM,
        GetItemsResource::IMAGESVARIANTSLARGE,
        GetItemsResource::OFFERSLISTINGSDELIVERY_INFOIS_PRIME_ELIGIBLE,
        GetItemsResource::ITEM_INFOFEATURES,
        GetItemsResource::ITEM_INFOBY_LINE_INFO,
        GetItemsResource::ITEM_INFOCONTENT_INFO,
        GetItemsResource::ITEM_INFOPRODUCT_INFO,
        GetItemsResource::ITEM_INFOTECHNICAL_INFO,
        GetItemsResource::BROWSE_NODE_INFOBROWSE_NODESSALES_RANK
    );

    # Forming the request
    $getItemsRequest = new GetItemsRequest();
    $getItemsRequest->setItemIds($itemIds);
    $getItemsRequest->setPartnerTag($partnerTag);
    $getItemsRequest->setPartnerType(PartnerType::ASSOCIATES);
    $getItemsRequest->setResources($resources);

    # Validating request
    $invalidPropertyList = $getItemsRequest->listInvalidProperties();
    $length = count($invalidPropertyList);
    if ($length > 0) {
        echo "Error forming the request", PHP_EOL;
        foreach ($invalidPropertyList as $invalidProperty) {
            echo $invalidProperty, PHP_EOL;
        }
        return;
    }

    # Sending the request
    try {
        $getItemsResponse = $apiInstance->getItems($getItemsRequest);

        // echo 'API called successfully', PHP_EOL;
        // echo 'Complete Response: ', $getItemsResponse, PHP_EOL;

        return $getItemsResponse;

        // if ($getItemsResponse->getErrors() != null) {
        //     echo PHP_EOL, 'Printing Errors:', PHP_EOL, 'Printing first error object from list of errors', PHP_EOL;
        //     echo 'Error code: ', $getItemsResponse->getErrors()[0]->getCode(), PHP_EOL;
        //     echo 'Error message: ', $getItemsResponse->getErrors()[0]->getMessage(), PHP_EOL;
        // }
    } catch (ApiException $exception) {
        $getItemsResponse = array();
        $getItemsResponse['status'] = 'error';
        $getItemsResponse['error'] = "Error calling PA-API 5.0!" . PHP_EOL;
        $getItemsResponse['error'] .= "HTTP Status Code: " . $exception->getCode() . PHP_EOL;
        $getItemsResponse['error'] .= "Error Message: " . $exception->getMessage() . PHP_EOL;
        if ($exception->getResponseObject() instanceof ProductAdvertisingAPIClientException) {
            $errors = $exception->getResponseObject()->getErrors();
            foreach ($errors as $error) {
                $getItemsResponse['error'] .= "Error Type: " . $error->getCode() . PHP_EOL;
                $getItemsResponse['error'] .= "Error Message: " . $error->getMessage() . PHP_EOL;
            }
        } else {
            $getItemsResponse['error'] .= "Error response body: " . $exception->getResponseBody() . PHP_EOL;
        }
        return $getItemsResponse;
    } catch (Exception $exception) {
        $getItemsResponse = array();
        $getItemsResponse['status'] = 'error';
        $getItemsResponse['error'] .= "Error Message: " . $exception->getMessage() . PHP_EOL;
        return $getItemsResponse;
    }
}

