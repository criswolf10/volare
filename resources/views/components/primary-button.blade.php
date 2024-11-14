
<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'flex w-full h-14 justify-center text-center mt-3 items-center px-4 py-1 bg-[#22B3B2] bg-opacity-100 text-opacity-100 border border-transparent rounded-md font-semibold text-sm md:text-lg lg:text-lg text-white tracking-widest
                hover:bg-opacity-75 hover:text-opacity-75 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
