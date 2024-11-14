
<!-- resources/views/components/nav-link.blade.php -->
@props(['href', 'active' => false, 'imgSrc', 'imgAlt' => 'Nav Image'])

<div class="{{ $active ? 'xl:mr-2' : '' }} flex justify-center items-center xl:justify-start xl:h-16 transition-all duration-200 bg-[#22B3B2] w-full">
    <a href="{{ $href }}" class="flex items-center justify-center">
        <img src="{{ asset($imgSrc) }}" alt="{{ $imgAlt }}" class="w-6 h-6 md:w-8 md:h-8 xl:w-10 xl:h-10">
    </a>
</div>
