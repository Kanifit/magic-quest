<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ (isset($title) ? $title . ' | ' : '') . config('app.name', 'MagicBook') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/plugins.css') }}" rel="stylesheet">
    <link href="{{ mix('css/book.css') }}" rel="stylesheet">
</head>
<body class="blockScroll theme-auto">
    <div id="app">
        <div class="header clearfix" v-if="currentTab.name !== 'Profile'">
            <div class="search-btn">
                <i class="material-icons" v-on:click="openSearch">search</i>
            </div>
            <div class="add">
                <i class="material-icons">add</i>
            </div>
            <div class="title">
                <div class="maintitle">@{{ currentTab.title }}</div>
            </div>
        </div>
        
        <transition name="searchanim" mode="out-in">
            <search v-if="searchActive" v-on:closing-search="closeSearch"></search>
        </transition>

        <transition name="bookinfo" mode="out-in" v-on:after-enter="afterBookInfoEnter">
            <book-info
                v-if="bookInfoState" 
                v-bind:book="openedBook"
                v-on:close-book-info="closeBookInfoBlock"
                v-on:error-open-book-info="bookInfoOpenError"
                v-bind:animation-done="animationDone"
                ></book-info>
        </transition>

        <keep-alive>
            <component v-bind:is="currentTabComponent"></component>
        </keep-alive>

        <nav-bar 
            v-bind:tabs="tabs" 
            v-bind:current-tab="currentTab" 
            v-on:changing-tab="changeTab"
            >
        </nav-bar>

        <div class="loader" v-if="loading"></div>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('js/tween.umd.js') }}"></script>
</body>
</html>