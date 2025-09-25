<!doctype html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>Nowe zgłoszenie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> {{-- important for mobile --}}
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
        }

        img {
            border: 0;
            outline: none;
            text-decoration: none;
            display: block;
            max-width: 100%;
            height: auto;
        }

        body {
            font-family: Quicksand, Arial, sans-serif;
            color: #34323a;
            background: #fff5f7;
        }

        .wrap {
            width: 100%;
            max-width: 640px;
            margin: 32px auto;
            background: #ffffff;
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

        .row {
            margin: 8px 0;
        }

        .label {
            font-weight: 700;
            color: #d64e72;
        }

        .label-end {
            margin: 16px 0;
            font-size: 12px;
            color: #777;
        }

        .btn {
            display: inline-block;
            background: #d64e72;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: 600;
            margin: 20px auto 0;
        }

        .btn:active,
        .btn:visited {
            color: #ffffff !important;
        }

        /* Mobile tweaks */
        @media only screen and (max-width: 480px) {
            .wrap {
                padding: 16px;
                border-radius: 12px;
            }

            .h1 {
                font-size: 20px;
            }

            .box {
                padding: 14px;
            }

            .row {
                margin: 6px 0;
            }
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="brand">
            <img src="{{ $logoUrl }}" alt="Logo" style="max-height:60px; margin:0 auto; display:block;">
        </div>

        <h1 class="h1">Nowe zgłoszenie z formularza kontaktowego</h1>
        <p class="muted">Poniżej szczegóły wiadomości przesłanej ze strony.</p>

        <div class="box">
            <div class="row"><span class="label">Imię:</span> {{ $data['first_name'] }}</div>
            <div class="row"><span class="label">Nazwisko:</span> {{ $data['last_name'] }}</div>
            <div class="row"><span class="label">E-mail:</span> {{ $data['email'] }}</div>
            <div class="row">
                <span class="label">Wiadomość:</span><br>
                {!! nl2br(e($data['message'])) !!}
            </div>
        </div>

        <p class="label-end">Wiadomość wygenerowana automatycznie.</p>

        <p style="text-align:center;">
            <a href="mailto:{{ $data['email'] }}" class="btn">Odpowiedz bezpośrednio</a>
        </p>
    </div>
</body>

</html>
