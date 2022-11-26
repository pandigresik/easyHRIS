<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ config('app.url') }}" />
    <title>{{config('app.name')}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <% for(var i=0; i < htmlWebpackPlugin.files.css.length; i++) {%>
        <link type="text/css" rel="stylesheet" href="{{ asset(mix('<%= htmlWebpackPlugin.files.css[i] %>')) }}">
    <% } %>    
    @stack('styles')
</head>

<body>
    @include('layouts.sidebar')
    @include('layouts.main')

    <% for(var i=0; i < htmlWebpackPlugin.files.js.length; i++) {%>
        <script type="text/javascript" src="{{ asset(mix('<%= htmlWebpackPlugin.files.js[i].replace('//js','/js') %>')) }}"></script>
    <% } %>
    <!-- adjust set moment to your locale setting -->    
    <script>
        moment.locale("{{ config('app.locale_moment') }}")
    </script>
    @stack('scripts')
</body>


</html>