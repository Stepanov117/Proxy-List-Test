<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Proxy List</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                font-weight: 100;
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

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            #proxy-list {
                margin-top: 25px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="title m-b-md">
                PROXY LIST
            </div>
            <div class="container" id="filter">
                <form action="/" method="get">
                    <div class="row">
                        <div class="col-sm">
                            <p><b>Country:</b></p>
                            <select name="country" class="form-control">
                            @foreach ($countryValues as $value)
                                @if ($fieldsFilter['country'] == $value)
                                    <option value="{{$value}}" selected>{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                        <div class="col-sm">
                            <p><b>Anonymity:</b></p>
                            <select name="anonymity" class="form-control">
                            @foreach ($anonymityValues as $value)
                                @if ($fieldsFilter['anonymity'] == $value)
                                    <option value="{{$value}}" selected>{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                        <div class="col-sm">
                            <p><b>Https:</b></p>
                            <select name="https" class="form-control">
                            @foreach ($httpsValues as $value)
                                @if ($fieldsFilter['https'] == $value)
                                    <option value="{{$value}}" selected>{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                        <div class="col-sm">
                            <p><b>Checked:</b></p>
                            <select  name="checked" class="form-control">
                            @foreach ($checkedValues as $value)
                                @if ($fieldsFilter['checked'] == $value)
                                    <option value="{{$value}}" selected>{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                        <div class="col-sm align-self-end">
                            <input type="submit" value="Filter" class="btn btn-info">
                        </div>
                    </div>
                </form>
            </div>
            <div class="container" id="proxy-list">
                <table class="table table-sm table-dark">
                    <tr>
                        <th>№</th>
                        <th>IP Address</th>
                        <th>Port</th>
                        <th>Country</th>
                        <th>Anonymity</th>  
                        <th>Https</th>
                        <th>Last Checked</th>	
                    </tr>
                @forelse ($proxyList as $proxy)
                    <tr>
                        <td>{{ $proxy['i'] }}</td>
                        <td>{{ $proxy['ip'] }}</td>
                        <td>{{ $proxy['port'] }}</td>
                        <td>{{ $proxy['country'] }}</td>
                        <td>{{ $proxy['anonymity'] }}</td>
                        <td>{{ $proxy['https'] }}</td>
                        <td>{{ $proxy['checked'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Empty proxy list.</td>
                    </tr>
                @endforelse
                </table>
            </div>
        </div>
    </body>
</html>
