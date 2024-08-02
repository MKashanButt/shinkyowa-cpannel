<select
    class="block mt-1 w-full p-2 bg-gray-200 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    id="role" name="role" required>
    <option value="" disabled>Select Role</option>
    @foreach ($roles as $role)
        <option value="{{ $role }}">{{ ucwords($role) }}</option>
    @endforeach
</select>
