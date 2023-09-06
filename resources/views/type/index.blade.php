<x-app-layout>

    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Types</h1>

        <a href="{{ route('type.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Create type</a>

        <table class="min-w-full bg-white shadow-md rounded my-4">
            <thead>
            <tr>
                <th class="py-2 px-4 bg-gray-200 font-semibold text-sm">ID</th>
                <th class="py-2 px-4 bg-gray-200 font-semibold text-sm">Name</th>
                <th class="py-2 px-4 bg-gray-200 font-semibold text-sm">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($types as $item)
                <tr>
                    <td class="py-2 px-4">{{ $item->id }}</td>
                    <td class="py-2 px-4">{{ $item->name }}</td>
                    <td class="py-2 px-4">
                        <a href="{{ route('type.edit', $item->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded inline-block">Edit</a>
                        <form method="POST" action="{{ route('type.destroy', $item->id) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded inline-block" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
