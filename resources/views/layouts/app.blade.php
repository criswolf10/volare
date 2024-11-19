<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <title>@yield('title')</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen antialiased m-0 p-0 bg-[#E4F2F2]">
    <div class="flex flex-col w-full h-screen ">
        <!-- Seccion del header -->
        <div id="header" class="flex fixed h-16 w-full md:h-20 lg:h-24 z-20">
            <!-- boton menu hamburguesa -->
            <div class="flex w-[15%] h-full justify-center items-center bg-[#22B3B2] sm:w-[10%] xl:w-[7%] 2xl:w-[6%] 3xl:w-[5%] ">
                <img src="{{ asset('icons/nav.png') }}" alt="menu" id="menu-toggle" class="cursor-pointer w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 lg:w-14 lg:h-14 xl:w-16 xl:h-16">
            </div>
            <!-- Contenido del header -->
            <div class="flex w-[85%] bg-[#0A2827] justify-between items-center  sm:w-[90%] xl:w-[93%] 2xl:w-[94%] 3xl:w-[95%]">
                @include('components.header')
            </div>
        </div>

        <!-- sidebar y contenido -->
        <div class="flex flex-col w-full xl:flex-row">
            <!-- menu de navegación, por defecto oculto -->
            <nav id="sidebar" class="hidden fixed w-full h-16 transition-all duration-300 md:h-20 lg:h-24 xl:block xl:h-full xl:w-[7%] 2xl:w-[6%] 3xl:w-[5%] z-10">
                @include('components.navigation')
            </nav>

            <!-- sección del main -->
            <main id="content" class="p-5 md:p-5 flex h-auto justify-center items-center w-full xl:w-[93%] 3xl:w-[95%] xl:ml-[7%] 2xl:ml-[6%] 3xl:ml-[5%]">
                <div class="flex flex-col w-full min-h-screen bg-white rounded-lg mt-16 md:mt-20 lg:mt-24">
                    <h2 class=" flex mt-5 text-xl xl:text-3xl ml-4 xl:ml-6 font-bold mb-4 uppercase">
                        @yield('title-page')
                    </h2>
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
