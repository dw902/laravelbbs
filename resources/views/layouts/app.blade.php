<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--     继承此模板的页面，如果没有定制 title 区域的话，就会自动使用第二个参数 LaraBBS 作为标题前缀。--}}

{{--    <title>@yield('title', 'LaraBBS') - Laravel 进阶教程</title>--}}
    <title>@yield('title', 'LaraBBS') - Laravel 进阶教程</title>
    <meta name="description" content="@yield('description', 'LaraBBS 爱好者社区')" />

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('styles')

</head>

<body>
<div id="app" class="{{ route_class() }}-page">

    @include('layouts._header')

    <div class="container">

        @include('shared._messages')

        @yield('content')

    </div>

    @include('layouts._footer')
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('scripts')
</body>

</html>
