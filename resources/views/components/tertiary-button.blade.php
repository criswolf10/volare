<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'text-white flex w-full h-10 justify-center items-center px-4 py-1 bg-[#22B3B2] border border-transparent rounded-md font-bold text-md md:text-lg tracking-widest
                hover:bg-opacity-75 hover:text-opacity-75 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
