<?php #paapi5
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
 * This sample code snippet is for ProductAdvertisingAPI 5.0's SearchItems API
 *
 * For more details, refer: https://webservices.amazon.com/paapi5/documentation/search-items.html
 */

use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\api\DefaultApi;
use Amazon\ProductAdvertisingAPI\v1\ApiException;
use Amazon\ProductAdvertisingAPI\v1\Configuration;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsResource;
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


function alp_api5_searchItems( $search_term, $aff_id, $page )
{
    $config = new Configuration();


    // echo '$search_term: ' . $search_term;

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

    // echo '$partnerTag: ' . $partnerTag;
    // die();

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

    # Specify keywords
    $keyword = $search_term;

    /*
     * Specify the category in which search request is to be made
     * For more details, refer: https://webservices.amazon.com/paapi5/documentation/use-cases/organization-of-items-on-amazon/search-index.html
     */
    $searchIndex = "All";

    # Specify item count to be returned in search result
    $itemCount = 10;

    $itemPage = (int)$page;

    /*
     * Choose resources you want from SearchItemsResource enum
     * For more details, refer: https://webservices.amazon.com/paapi5/documentation/search-items.html#resources-parameter
     */
    $resources = array(
        SearchItemsResource::ITEM_INFOTITLE,
        SearchItemsResource::ITEM_INFOMANUFACTURE_INFO,
        SearchItemsResource::OFFERSLISTINGSPRICE,
        SearchItemsResource::IMAGESPRIMARYLARGE,
        SearchItemsResource::IMAGESPRIMARYMEDIUM,
        SearchItemsResource::IMAGESPRIMARYSMALL,
        SearchItemsResource::IMAGESVARIANTSSMALL,
        SearchItemsResource::IMAGESVARIANTSMEDIUM,
        SearchItemsResource::IMAGESVARIANTSLARGE,
        SearchItemsResource::OFFERSLISTINGSDELIVERY_INFOIS_PRIME_ELIGIBLE,
        SearchItemsResource::ITEM_INFOFEATURES,
        SearchItemsResource::ITEM_INFOBY_LINE_INFO,
        SearchItemsResource::ITEM_INFOCONTENT_INFO,
        SearchItemsResource::ITEM_INFOPRODUCT_INFO,
        SearchItemsResource::ITEM_INFOTECHNICAL_INFO,
        SearchItemsResource::BROWSE_NODE_INFOBROWSE_NODESSALES_RANK
    );

    # Forming the request
    $searchItemsRequest = new SearchItemsRequest();
    $searchItemsRequest->setSearchIndex($searchIndex);
    $searchItemsRequest->setKeywords($keyword);
    $searchItemsRequest->setItemCount($itemCount);
    $searchItemsRequest->setItemPage($itemPage);
    $searchItemsRequest->setPartnerTag($partnerTag);
    $searchItemsRequest->setPartnerType(PartnerType::ASSOCIATES);
    $searchItemsRequest->setResources($resources);

    # Validating request
    $invalidPropertyList = $searchItemsRequest->listInvalidProperties();
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
        $searchItemsResponse = $apiInstance->searchItems($searchItemsRequest);

        // This is our valid response we will send back and parse in the browser.
        return $searchItemsResponse;

        
    } catch (ApiException $exception) {
        $searchItemsResponse = array();
        $searchItemsResponse['status'] = 'error';
        $searchItemsResponse['error'] = "Error calling PA-API 5.0!" . PHP_EOL;
        $searchItemsResponse['error'] .= "HTTP Status Code: " . $exception->getCode() . PHP_EOL;
        $searchItemsResponse['error'] .= "Error Message: " . $exception->getMessage() . PHP_EOL;
        if ($exception->getResponseObject() instanceof ProductAdvertisingAPIClientException) {
            $errors = $exception->getResponseObject()->getErrors();
            foreach ($errors as $error) {
                $searchItemsResponse['error'] .= "Error Type: " . $error->getCode() . PHP_EOL;
                $searchItemsResponse['error'] .= "Error Message: " . $error->getMessage() . PHP_EOL;
            }
        } else {
            $searchItemsResponse['error'] .= "Error response body: " . $exception->getResponseBody() . PHP_EOL;
        }
        return $searchItemsResponse;
    } catch (Exception $exception) {
        $searchItemsResponse = array();
        $searchItemsResponse['status'] = 'error';
        $searchItemsResponse['error'] .= "Error Message: " . $exception->getMessage() . PHP_EOL;
        return $searchItemsResponse;
    }
}
