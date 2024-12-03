<section>
<div class="flex flex-col justify-start bg-white shadow-lg rounded-lg p-5 gap-2">
    <h2 class="text-lg xl:text-3xl font-semibold text-gray-900">
        {{ __('Introduce los datos del nuevo vuelo') }}
    </h2>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('flight-create') }}" class="mt-4">
        @csrf
        @method('patch')

        <!-- Flight -->
        


        <x-input-error :messages="$errors->get('password')" class="mt-2 text-center" />

    </form>

</div>
</div>

</section>
