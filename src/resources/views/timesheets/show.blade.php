<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>タイムシート</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div>
        @if (empty($transformedTimesheets))
            <p class="alert alert-success">
                タイムシートはありません。
            </p>
        @else
        <div>
            @foreach($transformedTimesheets as $key => $timesheet)
                <div>
                    <h2>{{ $key }}</h2>
                    @if(empty($timesheet))
                        <p>該当なし</p>
                    @endif
                    @foreach($timesheet as $plan_name => $users)
                        <p>{{ $plan_name }}</p>
                        <p>
                            @foreach($users as $user)
                                {{ $user }}
                            @endforeach
                        </p>
                    @endforeach
                </div>
            @endforeach
        </div>
        @endif
    </div>
</body>
</html>
