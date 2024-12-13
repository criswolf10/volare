<div id="filter-modal" class="absolute hidden mt-2 bg-white shadow-lg p-6 rounded-lg w-96">
    <h3 class="text-xl mb-4">{{ $title }}</h3>
    <form id="filter-form">
        @foreach ($fields as $field)
            <div class="mb-4">
                @if ($field['type'] === 'select')
                    <label class="block mb-2">{{ $field['label'] }}</label>
                    <select
                        class="form-input border rounded px-3 py-2 w-full {{ $field['class'] ?? '' }}"
                        name="{{ $field['name'] }}">
                        @foreach ($field['options'] as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                @elseif ($field['type'] === 'range')
                    <label class="block mb-2">{{ $field['label'] }}</label>
                    <input
                        type="range"
                        class="form-input border rounded px-3 py-2 w-full {{ $field['class'] ?? '' }}"
                        name="{{ $field['name'] }}"
                        min="{{ $field['min'] }}"
                        max="{{ $field['max'] }}"
                    >
                @elseif ($field['type'] === 'date')
                    <label class="block mb-2">{{ $field['label'] }}</label>
                    <input
                        type="date"
                        class="form-input border rounded px-3 py-2 w-full {{ $field['class'] ?? '' }}"
                        name="{{ $field['name'] }}"
                    >
                @endif
            </div>
        @endforeach

        <div class="mt-4 flex justify-between">
            <button type="button" class="bg-gray-500 text-white py-2 px-4 rounded" id="cancel-filter">Cancelar</button>
            <button type="submit" class="bg-[#22B3B2] text-white py-2 px-4 rounded">Aplicar</button>
        </div>
    </form>
</div>
