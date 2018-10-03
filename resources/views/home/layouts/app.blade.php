<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'InNote') | 记录让编码更高效@show - Powered by Evan</title>
    <meta name="keywords" content="编程,编码,编程学习,编程技巧,编程知识,php,javascript,laravel,java,vuejs ">
    <meta name="description"
          content="@yield('description', '这里是一个程序员分享编程知识和协作的平台。你可以在这里记录编程小贴士、编程小技巧或者编码日志。')">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        window.Crsf = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>;
    </script>

    @yield('style')

</head>

<body>
<div id="app" class="{{ route_class() }}-page">

    <div class="main container">

        @include('home.layouts._header')

        <div class="ui centered grid container stackable">

            @yield('content')

        </div>

    </div>

    {{--<a class="circular ui icon button fixed feedback popover" data-content="建议与反馈 @Evan" data-position="left center"--}}
       {{--href="#">--}}
        {{--<i class="icon talk outline"></i>--}}
    {{--</a>--}}

    <backtop-ball></backtop-ball>

    @include('home.layouts._footer')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

{{--@include('flashy::message')--}}

@yield('javascript')

</body>
</html>