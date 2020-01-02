<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="css/app.css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <div class="doc-side">
            <ul class="list-features">
                @foreach($docs as $doc)
                    <li>
                        <p class="list-features__top">{{ $doc['section'] }}</p>
                        <ul class="list-features__sub_ul">
                            @foreach($doc['endpoints'] as $endpoint)
                                <li><a href="">{{ $endpoint['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>

        <main class="main-section">

            <div class="container">

                @foreach($docs as $doc)
            
                    <div class="api-feature">
                        <h2>{{ $doc['section'] }}</h2>

                        @foreach($doc['endpoints'] as $endpoint)
                            <div class="endpoint">
                                <p class="endpoint__name">{{ $endpoint['name'] }}</p>
                                <p class="endpoint__url">{{ $endpoint['url'] }}</p>
                                <code class="endpoint__payload">{{ $endpoint['payload'] }}</code>
                                <p class="endpoint__explain">{{ $endpoint['explain'] }}</p>
                            </div>
                        @endforeach
                    
                    </div>

                @endforeach

            </div>

        </main>

        <div class="container">

            <div class="row">
                <div class="col-sm-3">
                    
                </div>
                <div class="col-sm-9">

                    

                </div>
            </div>

            
        </div>
    </body>
</html>
