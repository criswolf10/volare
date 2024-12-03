<!-- Menú lateral -->
<div
    class=" bg-[#22B3B2] flex p-3 justify-around items-center h-full w-full xl:flex-col xl:h-full xl:justify-start xl:w-full xl:items-center xl:mt-24 2xl:mt-24 xl:gap-8">
    <div class="w-full flex justify-center items-center xl:ml-6 bg-[#E4F2F2]">
        <x-nav-link href="{{ auth()->check() ? route('dashboard') : route('login') }}" img-src="icons/dashboard.png"
            img-alt="Dashboard" :active="request()->is('dashboard')" />
    </div>

    <div class="w-full flex justify-centeritems-center xl:ml-6 bg-[#E4F2F2]">
        <x-nav-link href="{{ route('flights') }}" img-src="icons/flights.png" img-alt="Flights" :active="request()->is('flights')" />
    </div>

    <div class="w-full flex justify-centeritems-center xl:ml-6 bg-[#E4F2F2]">
        <x-nav-link href="{{ route('tickets') }}" img-src="icons/tickets.png" img-alt="tickets" :active="request()->is('tickets')" />
    </div>

    <div class="w-full flex justify-centeritems-center xl:ml-6 bg-[#E4F2F2]">
        <x-nav-link href="{{ route('users') }}" img-src="icons/users.png" img-alt="Users" :active="request()->is('users')" />
    </div>
</div>
