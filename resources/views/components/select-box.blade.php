<select
    class="block mt-1 w-full p-2 bg-gray-200 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    id="{{ $id }}" name="{{ $name }}">
    <option value="" selected>{{ $placeholder }}</option>
    @foreach ($data as $item)
        @if ($column != 'none')
            <option value="{{ $item->column }}">{{ ucwords($item->$column) }}</option>
        @else
            <option value="{{ $item }}">{{ ucwords($item) }}</option>
        @endif
    @endforeach
</select>
