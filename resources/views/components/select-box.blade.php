<select
    class="block mt-1 w-full p-2 bg-gray-200 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    id="{{ $id }}" name="{{ $name }}">
    <option value="" selected>{{ $placeholder }}</option>
    @foreach ($data as $item)
        <option value="{{ $item }}">{{ ucwords(str_replace('_', ' ', $item)) }}</option>
    @endforeach
</select>
