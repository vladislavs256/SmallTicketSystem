<x-app-layout>

    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Type</h1>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('type.update', $type) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-600 font-semibold mb-2">Name</label>
                <input type="text"
                       class="form-input w-full border rounded-md py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500"
                       id="name" name="name" value="{{ old('name', $type->name) }}">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Update Type</button>
        </form>
    </div>
</x-app-layout>
