<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <base href="{{ config('app.url') }}" />
    <title>{{config('app.name')}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <% for(var i=0; i < htmlWebpackPlugin.files.css.length; i++) {%>
        <link type="text/css" rel="stylesheet" href="{{ asset(mix('<%= htmlWebpackPlugin.files.css[i] %>')) }}">
    <% } %>
</head>

<body class="app flex-row align-items-center">
    @yield('content')
    <% for(var i=0; i < htmlWebpackPlugin.files.js.length; i++) {%>
        <script type="text/javascript" src="{{ asset(mix('<%= htmlWebpackPlugin.files.js[i].replace('//js','/js') %>')) }}"></script>
    <% } %>    
</body>
</html>