<x-app-layout>

    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Create Type</h1>

        <!-- Display validation errors if any -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('type.store') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-600 font-semibold mb-2">Name</label>
                <input type="text" class="form-input w-full border rounded-md py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500" id="name" name="name" value="{{ old('name') }}">
            </div>


            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Create Type</button>
        </form>
    </div>
</x-app-layout>
