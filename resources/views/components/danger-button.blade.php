<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-white flex w-full h-10 justify-center mt-3 items-center px-4 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-md md:text-lg lg:text-lg tracking-widest
                hover:bg-opacity-75 hover:text-opacity-75 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
