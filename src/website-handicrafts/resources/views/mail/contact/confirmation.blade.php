<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <title>{{ __('messages.contact_confirm_subject') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body,
        table,
        td,
        a {
            text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100% !important;
            font-family: Quicksand, Arial, sans-serif;
            color: #34323a;
            background: #fff5f7;
        }

        img {
            display: block;
            max-width: 100%;
            height: auto;
            border: 0;
            outline: 0;
        }

        .wrap {
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
            background: #fff;
            padding: 24px;
            border-radius: 14px;
            box-sizing: border-box;
        }

        .brand {
            text-align: center;
            margin-bottom: 16px;
        }

        .brand img {
            max-height: 60px;
            margin: 0 auto;
        }

        .h1 {
            font-size: 22px;
            line-height: 1.3;
            color: #d64e72;
            margin: 0 0 12px;
        }

        .muted {
            color: #666;
            margin: 0 0 16px;
        }

        .box {
            border: 1px solid #f7e7ea;
            border-radius: 12px;
            padding: 16px;
            background: #f7d7de22;
        }

        .label-end {
            margin: 16px 0;
            font-size: 12px;
            color: #777;
        }

        .btn {
            display: inline-block;
            background: #d64e72;
            color: #fff !important;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: 600;
            margin: 20px auto 0;
        }

        @media only screen and (max-width:480px) {
            .wrap {
                padding: 16px;
                border-radius: 12px;
            }

            .h1 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="brand">
            <img src="{{ $logoUrl }}" alt="Logo">
        </div>

        <h1 class="h1">{{ __('messages.contact_confirm_title', ['name' => $data['first_name']]) }}</h1>
        <p class="muted">{{ __('messages.contact_confirm_intro') }}</p>

        <div class="box">
            <p><strong>{{ __('messages.contact_confirm_copy_heading') }}</strong></p>
            <p>{!! nl2br(e($data['message'])) !!}</p>
        </div>

        <p class="muted" style="margin-block: 16px">{{ __('messages.contact_confirm_note') }}</p>

        <p style="text-align:center;">
            <a href="{{ url('/') }}" class="btn">{{ __('messages.contact_confirm_cta') }}</a>
        </p>

        <p class="label-end">{{ __('messages.contact_confirm_footer') }}</p>
    </div>
</body>

</html>
