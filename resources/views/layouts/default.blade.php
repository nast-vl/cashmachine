<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Cash Machine</title>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.js"></script>

    <style type="text/css">
        body > .ui.container {
            margin-top: 3em;
        }

        .ui.container > h1 {
            font-size: 3em;
            text-align: center;
            font-weight: normal;
        }

        .ui.container > h2.dividing.header {
            font-size: 2em;
            font-weight: normal;
            margin: 2em 0em 2em;
        }
    </style>
</head>
<body>
    <div id="app" class="ui container" style="margin-top: 3rem">
        @yield('content')
    </div>
    @section('scripts')
        <script src="{!! mix('js/app.js') !!}"></script>
    @show
</body>
</html>
