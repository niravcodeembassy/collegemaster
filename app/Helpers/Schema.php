<?php

namespace App\Helpers;

use App\Setting;
use App\Model\ProductReview;

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

  public static function reviewSchema()
  {
    $global_review_avg = ProductReview::whereNull('is_active')->avg('rating');
    $global_review_count = ProductReview::whereNull('is_active')->count();

    $review_schema = [
      '@context' => 'https://schema.org/',
      '@type' => 'product',
      'name' => "Personalized 1st Birthday Wall Art Gift For Baby Girl/Boy",
      'image' => "Here at Collage Master, you can buy a personalized 1st birthday wall art gift for a baby girl, or boy with letters and memorize your day forever. Buy Now!!",
      'description' => "Here at Collage Master, you can buy a personalized 1st birthday wall art gift for a baby girl, or boy with letters and memorize your day forever. Buy Now!!",
      'brand' => [
        '@type' => 'Brand',
        'name' => env('APP_NAME'),
      ],
      'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => round($global_review_avg, 1),
        'bestRating' => '5',
        'worstRating' => '1',
        'ratingCount' => $global_review_count,
      ],
    ];
    return $review_schema;
  }
}