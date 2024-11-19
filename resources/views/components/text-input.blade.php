@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full h-14 border-gray-300 font-semibold focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ']) }}>
