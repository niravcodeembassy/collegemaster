@php
$stripeResponse = new StripeResponse();

$stripeData = $stripeResponse->retrieveStripePaymentData($requestData['session_id']);

@endphp
