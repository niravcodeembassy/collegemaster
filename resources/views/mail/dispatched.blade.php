<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @if(isset($settings))
    <link rel="icon" href="{{ $settings->favicon }}" type="image/x-icon" />
    @endif
    <title>Eshop</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

    <style type="text/css">
        body {
            text-align: center;
            margin: 0 auto;
            width: 650px;
            font-family: 'Open Sans', sans-serif;
            background-color: #e2e2e2;
            display: block;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            display: inline-block;
            text-decoration: unset;
        }

        a {
            text-decoration: none;
        }

        p {
            margin: 15px 0;
        }

        h5 {
            color: #444;
            text-align: left;
            font-weight: 400;
        }

        .text-center {
            text-align: center
        }

        .main-bg-light {
            background-color: #fafafa;
        }

        .title {
            color: #444444;
            font-size: 22px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 10px;
            padding-bottom: 0;
            text-transform: uppercase;
            display: inline-block;
            line-height: 1;
        }

        table {
            margin-top: 30px
        }

        table.top-0 {
            margin-top: 0;
        }

        table.order-detail {
            border: 1px solid #ddd;
            border-collapse: collapse;
        }

        table.order-detail tr:nth-child(even) {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        table.order-detail tr:nth-child(odd) {
            border-bottom: 1px solid #ddd;
        }

        .pad-left-right-space {
            border: unset !important;
        }

        .pad-left-right-space td {
            padding: 5px 15px;
        }

        .pad-left-right-space td p {
            margin: 0;
        }

        .pad-left-right-space td b {
            font-size: 15px;
            font-family: 'Roboto', sans-serif;
        }

        .order-detail th {
            font-size: 16px;
            padding: 15px;
            text-align: center;
            background: #fafafa;
        }

        .footer-social-icon tr td img {
            margin-left: 5px;
            margin-right: 5px;
        }

    </style>
</head>

<body style="margin: 20px auto;">
    <table align="center" border="0" cellpadding="0" cellspacing="0"
        style="padding: 0 30px;background-color: #fff; -webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);width: 100%;">
        <tbody>
            <tr>
                <td>
                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="text-align: left;"
                        width="100%">
                        <tr>
                            <td style="text-align: center;">
                                <img class="editable-area" width="80%"
                                    id="logo"
                                    src="{{ $setting->logo }}"
                                    style="margin-bottom: 30px;width: 130px;"  />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size: 14px;"><b>Dear {{ $order->user->name ?? '' }} </b></p>
                                <p style="font-size: 14px;line-height: 2;letter-spacing: 1px;">We would like to inform you that you order has been dispatched. Your order is on the way </p>
                            </td>
                        </tr>
                    </table>

                    <table cellpadding="0" cellspacing="0" border="0" align="left"
                        style="width: 100%;margin-top: 10px;    margin-bottom: 10px;">
                        <tbody>
                            <tr>
                                <td
                                    style="background-color: #fafafa;border: 1px solid #ddd;padding: 15px;letter-spacing: 0.3px;width: 50%;">
                                    <h5
                                        style="font-size: 16px; font-weight: 600;color: #000; line-height: 16px; padding-bottom: 13px; border-bottom: 1px solid #e6e8eb; letter-spacing: -0.65px; margin-top:0; margin-bottom: 13px;">Shipping Address</h5>
                                    <p
                                        style="text-align: left;font-weight: normal;margin-bottom:1px; font-size: 14px; color: #000000;line-height: 21px;    margin-top: 0;">
                                        @if($order->user->name) {{ $order->user->name ?? '' }}@endif
                                    </p>

                                    @if($order->user->name)
                                        <p style="text-align: left;font-weight: normal;margin-bottom:1px; font-size: 14px; color: #000000;line-height: 21px;    margin-top: 0;"> Mobile :  {{ $order->user->phone }}</p>
                                    @endif

                                    @php
                                        $address = json_decode($order->address);
                                        $shipping = $address->shipping_address;
                                    @endphp

                                    @if ($shipping->address_one)
                                        <p style="text-align: left;font-weight: normal;margin-bottom:1px; font-size: 14px; color: #000000;line-height: 21px;    margin-top: 0;">{{ $shipping->address_one }}
                                            @if ($shipping->address_two)
                                                ,{{ $shipping->address_two }}
                                            @endif
                                        </p>
                                    @endif
                                    <p style="text-align: left;font-weight: normal;margin-bottom:1px; font-size: 14px; color: #000000;line-height: 21px;    margin-top: 0;"> {{ $shipping->city ?? '' }} - {{ $shipping->postal_code ?? '' }}
                                        @if ($shipping->state)
                                            ,
                                            <br> {{ $shipping->state ?? '' }} - {{ $shipping->country ?? '' }}
                                        @endif

                                    </p>

                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

</body>

<!-- Mirrored from themes.pixelstrap.com/multikart/front-end/email-order-success-two.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Jan 2020 05:38:56 GMT -->

</html>
