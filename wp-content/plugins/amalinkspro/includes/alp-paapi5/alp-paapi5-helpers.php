<?php #paapi5


function alp_paapi5_get_amazon_keys() {
    $locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );
    $amazonKeysInfo['aws_access_key_id'] = trim( get_option( 'amalinkspro-options_amazon_api_access_key' ) );
    $amazonKeysInfo['aws_secret_key'] = trim( get_option( 'amalinkspro-options_amazon_api_secret_key' ) );
    $amazonKeysInfo['affiliate_id'] = trim( get_option( 'amalinkspro-options_'.$locale.'_amazon_associate_ids_0_associate_id' ) );
    return $amazonKeysInfo;
}



function alp_paapi5_get_endpoint() {

    $locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );

    // The region you are interested in
    if ( $locale == 'US' ) {
        $endpoint['endpoint'] = "webservices.amazon.com";
        $endpoint['region'] = 'us-east-1';
    }
    else if ( $locale == 'UK' ) {
        $endpoint['endpoint'] = "webservices.amazon.co.uk";
        $endpoint['region'] = 'eu-west-1';
    }
    else if ( $locale == 'BR' ) {
        $endpoint['endpoint'] = "webservices.amazon.com.br";
        $endpoint['region'] = 'us-east-1';
    }
    else if ( $locale == 'CA' ) {
        $endpoint['endpoint'] = "webservices.amazon.ca";
        $endpoint['region'] = 'us-east-1';
    }
    else if ( $locale == 'CN' ) {
        $endpoint['endpoint'] = "webservices.amazon.cn";
        $endpoint['region'] = 'eu-west-1';
    }
    else if ( $locale == 'FR' ) {
        $endpoint['endpoint'] = "webservices.amazon.fr";
        $endpoint['region'] = 'eu-west-1';
    }
    else if ( $locale == 'DE' ) {
        $endpoint['endpoint'] = "webservices.amazon.de";
        $endpoint['region'] = 'eu-west-1';
    }
    else if ( $locale == 'IN' ) {
        $endpoint['endpoint'] = "webservices.amazon.in";
        $endpoint['region'] = 'eu-west-1';
    }
    else if ( $locale == 'IT' ) {
        $endpoint['endpoint'] = "webservices.amazon.it";
        $endpoint['region'] = 'eu-west-1';
    }
    else if ( $locale == 'JP' ) {
        $endpoint['endpoint'] = "webservices.amazon.co.jp";
        $endpoint['region'] = 'us-west-2';
    }
    else if ( $locale == 'ES' ) {
        $endpoint['endpoint'] = "webservices.amazon.es";
        $endpoint['region'] = 'eu-west-1';
    }
    else if ( $locale == 'MX' ) {
        $endpoint['endpoint'] = "webservices.amazon.com.mx";
        $endpoint['region'] = 'us-east-1';
    }
    else if ( $locale == 'AU' ) {
        $endpoint['endpoint'] = "webservices.amazon.com.au";
        $endpoint['region'] = 'us-west-2';
    }

    return $endpoint;

}


function alp_paapi5_get_amazon_url_for_region() {

    $locale = trim( get_option( 'amalinkspro-options_default_amazon_search_locale' ) );

        // The region you are interested in
        if ( $locale == 'US' ) {
            $amazon_store_url = "amazon.com";
        }
        else if ( $locale == 'UK' ) {
            $amazon_store_url = "amazon.co.uk";
        }
        else if ( $locale == 'BR' ) {
            $amazon_store_url = "amazon.com.br";
        }
        else if ( $locale == 'CA' ) {
            $amazon_store_url = "amazon.ca";
        }
        else if ( $locale == 'CN' ) {
            $amazon_store_url = "amazon.cn";
        }
        else if ( $locale == 'FR' ) {
            $amazon_store_url = "amazon.fr";
        }
        else if ( $locale == 'DE' ) {
            $amazon_store_url = "amazon.de";
        }
        else if ( $locale == 'IN' ) {
            $amazon_store_url = "amazon.in";
        }
        else if ( $locale == 'IT' ) {
            $amazon_store_url = "amazon.it";
        }
        else if ( $locale == 'JP' ) {
            $amazon_store_url = "amazon.co.jp";
        }
        else if ( $locale == 'ES' ) {
            $amazon_store_url = "amazon.es";
        }
        else if ( $locale == 'MX' ) {
            $amazon_store_url = "amazon.com.mx";
        }
        else if ( $locale == 'AU' ) {
            $amazon_store_url = "amazon.com.au";
        }

        return $amazon_store_url;

}


function amalinkspro_alpAmazonUrl() {

    $alp_amazon_url = alp_paapi5_get_amazon_url_for_region();

    echo '<script type="text/javascript">
       var alpAmazonUrl = "https://' . $alp_amazon_url . '";
     </script>';

}

add_action( 'admin_head', 'amalinkspro_alpAmazonUrl' );






function alp_paapi5_get_groups_10_asins_data($asins, $aff_id) {

    // set our empty table_asins_groups array
    $table_asins_groups = array();

    // this is the array not broken into ten asins, that we will loop through below to create our final amazon data array to pull into the table below
    $table_asins_full_group = array();

    $asins_array = explode(',', $asins);
    $asins_array = array_unique($asins_array);


    // remove after testing!!! 
    // $asins_array = array('B0049J4O0K','B0092V7WJ0','B073XC3Y5J','B01I8L5HT6','B004BUAQEU','B07NVWHBBH','B004HZGR5Q','B07M6S469F','B071VZ7C2S','B07H5QJW86','B00EXLOVU2','B073WF2JMD','B00W8FN3Z4');

    $i=0;
    $z = 0;

    foreach( $asins_array as $asin ) {


        // filter out our non-api stuff
        if ( $asin != 'noasin' ) {

            $table_asins_groups[$z][$i] = $asin;
            $i++;

            if ($i % 10 == 0 ) {
                $z++;
                $i=0;
            }

        }

            

    }

    $x=0;

    $error_message = '';

    foreach ( $table_asins_groups as $asin_group ) {

        // this should throttle the API calls 1 per second
        $timestamp = time();
        while ($timestamp == time()) { 
           continue;
        }

        $api_response = alp_api5_getItems( $asin_group, $aff_id );

        if ( $api_response['status'] == 'error' ) {
            $error_message = $api_response['error'];
        }

        else {
            if($api_response) {
                $all_products_info_arr[$x] = $api_response;
            }
            else {
                $all_products_info_arr[$x] = null;
            }
            $x++;
        }


    }


    // narrow down our all prodyucts data array to just the "item" array form our xml response
    $new_products_info_arr = array();
    $w=0;
    $x=0;
    if ( $all_products_info_arr ) {

        foreach ( $all_products_info_arr as $arr ) {
            if ($arr) {

                $items = $arr['itemsResult']['items'];

                // echo '$items: <pre>'.print_r($items,1).'</pre>';

                foreach($items as $item) {
                    $items_array[$x] = $item;
                    $x++;
                }

            }
            $w++;
        }

    }

    
    // let's now build our final array pf product data, organized ny ASIN to look up quickly later
    $final_item_data = array();

    // loop through all of our items
    if ($items_array) {
        foreach($items_array as $item) {

            // echo '$item: <pre>'.print_r($item,1).'</pre>';
            $asin = $item['aSIN'];
            // add each product's data to the final array, with the asin for the key for easy lookup later
            $final_item_data[''.$asin.'']['asin'] = $asin;
            $final_item_data[''.$asin.'']['detailPageURL'] = $item['detailPageURL'];

            $final_item_data[''.$asin.'']['primaryImgUrlSm'] = $item['images']['primary']['small']['uRL'];
            $final_item_data[''.$asin.'']['primaryImgUrlMd'] = $item['images']['primary']['medium']['uRL'];
            $final_item_data[''.$asin.'']['primaryImgUrlLg'] = $item['images']['primary']['large']['uRL'];

            $variations = $item['images']['variants'];

            $img_variants = array();

            $i=0;

            foreach ($variations as $img) {
                $img_variants[$i]['sm'] = $img['small']['uRL'];
                $img_variants[$i]['md'] = $img['medium']['uRL'];
                $img_variants[$i]['lg'] = $img['large']['uRL'];
                $i++;
            }

            $final_item_data[''.$asin.'']['imgVariants'] = $img_variants;

            $final_item_data[''.$asin.'']['features'] = $item['itemInfo']['features']['displayValues'];

            $final_item_data[''.$asin.'']['title'] = $item['itemInfo']['title']['displayValue'];
            $final_item_data[''.$asin.'']['brand'] = $item['itemInfo']['byLineInfo']['brand']['displayValue'];
            $final_item_data[''.$asin.'']['model'] = $item['itemInfo']['manufactureInfo']['model']['displayValue'];
            $final_item_data[''.$asin.'']['warranty'] = $item['itemInfo']['manufactureInfo']['warranty']['displayValue'];

            $final_item_data[''.$asin.'']['offerDisplay'] = $item['offers']['listings'][0]['price']['displayAmount'];
            $final_item_data[''.$asin.'']['offerSortVal'] = $item['offers']['listings'][0]['price']['amount'];

            $final_item_data[''.$asin.'']['prime'] = $item['offers']['listings'][0]['deliveryInfo']['isPrimeEligible'];

            $final_item_data[''.$asin.'']['author'] = $item['itemInfo']['byLineInfo']['contributors'][0]['name'];
            $final_item_data[''.$asin.'']['pagesCount'] = $item['contentInfo']['pagesCount']['dsplayValue'];
            $final_item_data[''.$asin.'']['publicationDate'] = $item['contentInfo']['publicationDate']['displayValue'];
            $final_item_data[''.$asin.'']['releaseDate'] = $item['productInfo']['releaseDate']['displayValue'];
            
        }
    }

    if ( $error_message != '' ) {
        $final_item_data['error'] = $error_message;
    }

    // echo '$final_item_data: <pre>'.print_r($final_item_data,1).'</pre>';
    // die();

    return $final_item_data;

}














