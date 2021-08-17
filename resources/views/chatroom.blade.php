<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ChatBear') }}</title>
        @livewireStyles
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
            <script>
                     window.OneSignal = window.OneSignal || [];
                     OneSignal.push(function() {
                       OneSignal.init({
                         appId: "5a50b1f0-8f3c-4a23-8845-569719f996c6",
                       });
                    });
                </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                
            </header>

            <!-- Page Content -->
            <main>
                @livewire('chat', ['id' => $id, 'userId' => Auth::user()])
            </main>
        </div>
        @livewireScripts
    </body>
</html>
