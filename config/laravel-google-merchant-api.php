<?php

return [

  /*
	|--------------------------------------------------------------------------
	| Default merchant
	|--------------------------------------------------------------------------
	|
	| Set the default merchant from below configurations.
	*/

  'default_merchant' => 'moirei',

  /*
	|--------------------------------------------------------------------------
	| API Mode
	|--------------------------------------------------------------------------
	|
	| Set the API version to use.
	*/

  'version' => 'v2.1',

  /*
	|--------------------------------------------------------------------------
	| Client Config
	|--------------------------------------------------------------------------
	|
	| Optional configurations for the guzzle client.
	| Accepts only 'timeout', 'headers', 'proxy', 'allow_redirects', 'http_errors', 'decode_content', 'verify', 'cookies'
	*/

  'client_config' => [
    'timeout' => null, // in seconds, allow sufficient time on each call since instantiating each request has to also authenticate
    'proxy' => null, // null values are ignored
  ],

  /*
	|--------------------------------------------------------------------------
	| Merchant Credentials
	|--------------------------------------------------------------------------
	|
	| Nerchant credentials' configurations
	*/

  'merchants' => [
    'moirei' => [
      /*
            |--------------------------------------------------------------------------
            | Application Name
            |--------------------------------------------------------------------------
            |
            | The application name to pass to the Google client.
            | Set as null to ignore.
            */
      'app_name' => config('app.name'),

      /*
            |--------------------------------------------------------------------------
            | Google Merchant ID
            |--------------------------------------------------------------------------
            |
            | Your Merchant ID for Google Shopping API.
            | This is a numeric value.
            */
      'merchant_id' => env('GOOGLE_MERCHANT_ID_MOIREI', '592418806'),

      /*
            |--------------------------------------------------------------------------
            | Service Account
            |--------------------------------------------------------------------------
            |
            | The base path url to json file that holds your service account credentials.
            | This file should only be accessible to your application.
            */
      'client_credentials_path' => storage_path('app/google-merchant-api/content-api-key.json'),
    ]
  ],

  /*
	|--------------------------------------------------------------------------
	| Contents Config
	|--------------------------------------------------------------------------
	|
	| Configuration for the API contents
	*/

  'contents' => [
    'products' => [
      'model' => \App\Model\Product::class,
      'attributes' => [
        /*
                 * Options:
                 *
                 * 'offerId', 'title', 'description', 'link', 'imageLink',
                 * 'contentLanguage' (defaults to "en"),
                 * 'targetCountry' (defaults to "AU"),
                 * 'channel' (defaults to "online"),
                 * 'condition' (defaults to "new"),
                 * 'availability' (defaults to "in stock"),
                 * 'ageGroup', 'availabilityDate', 'brand', 'color',
                 * 'gender', 'googleProductCategory', 'gtin', 'itemGroupId', 'mpn',
                 * 'price', 'sizes', 'customAttributes',
                 */

        'offerId' => 'id',
        'title' => 'name',
        'description' => 'short_content',
        'itemGroupId' => 'itemGroupId',
        'link' => 'link',
        'imageLink' => 'imageLink',
        'availability' => 'in_stock', // "in stock", "out of stock", or "preorder"
        'brand' => 'brand',
        'mpn' => 'mpn',
        'price' => 'price', // must return array (2): value, and currency
        'salePrice' => 'salePrice', // must return array (2): value, and currency
        'sizes' => 'sizes',
        'customAttributes' => 'customAttributes'
      ],
      'defaults' => [
        'contentLanguage' => 'en',
        'targetCountry' => 'IN',
        'channel' => 'online',
        'availability' => 'in stock',
        'condition' => 'new',
      ],
    ],
    'orders' => [
      'schedule_orders_check' => true,
      'schedule_frequency' => 'daily',
      'debug_scout' => false,
    ],
  ],

  /*
	|--------------------------------------------------------------------------
	| Default Currency
	|--------------------------------------------------------------------------
	|
	| Default product currency
	*/

  'default_currency' => 'USD',
];
