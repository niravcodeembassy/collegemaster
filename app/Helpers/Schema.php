<?php

namespace App\Helpers;

use App\Setting;

class Schema
{

  public static function localSchema()
  {
    $setting = Setting::first()->response;
    $schema_local = [
      '@context' => 'https://schema.org/',
      '@type' => 'LocalBusiness',
      'name' => $setting->store_name,
      'image' => asset('storage/' . $setting->logo),
      '@id' => '',
      'url' => env('APP_URL'),
      'telephone' => $setting->contact,
      'priceRange' => "$24.99",
      'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => $setting->address,
        'addressLocality' => $setting->city,
        'postalCode' => $setting->postal_code,
        'addressCountry' => 'IN',
      ],
      'geo' => [
        '@type' => 'GeoCoordinates',
        'latitude' => 21.2074785,
        'longitude' => 72.8344551,
      ],
    ];
    return $schema_local;
  }

  public static function organizationSchema()
  {
    $setting = Setting::first()->response;
    $schema_organization = [
      '@context' => 'https://schema.org/',
      '@type' => 'Organization',
      'name' => $setting->store_name,
      'alternateName' => $setting->store_name,
      'url' => env('APP_URL'),
      'logo' => asset('storage/' . $setting->logo),
      'contactPoint' => [
        '@type' => 'contactPoint',
        'telephone' => $setting->contact,
        'contactType' => 'customer service',
        'contactOption' => 'HearingImpairedSupported',
        'areaServed' => ['US', 'IN'],
        'availableLanguage' => ['en', 'Hindi'],
      ],
      'sameAs' => [$setting->facebook, $setting->instagram, $setting->whatsapp, $setting->pinterest],
    ];
    return $schema_organization;
  }
}