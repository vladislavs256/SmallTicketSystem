<x-app-layout>
    <div class="flex justify-center px-2"> <!-- Ticket System Container -->
        <table class="w-full max-w-3xl table-auto">
            <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Subject</th>
                <th class="px-4 py-2">Content</th>
                <th class="px-4 py-2">Type</th>
                <th class="px-4 py-2">Created</th>
                <th class="px-4 py-2">Updated</th>
                <th class="px-4 py-2">Status</th>
            </tr>
            </thead>
            <tbody> @foreach ($tickets as $ticket)
                <tr>
                    <td class="border px-4 py-2">{{ $ticket->id }}</td>
                    <td class="border px-4 py-2">{{ $ticket->subject }}</td>
                    <td class="border px-4 py-2">{{ $ticket->content }}</td>
                    <td class="border px-4 py-2">{{ $ticket->type_id }}</td>
                    <td class="border px-4 py-2">{{ $ticket->created_at }}</td>
                    <td class="border px-4 py-2">{{ $ticket->updated_at }}</td>
                    <td class="border px-4 py-2">
                        @if ($ticket->isOpen())
                            <span class="inline-block bg-red-500 text-white px-2 py-1 rounded">Open</span>
                        @elseif ($ticket->isApproved())
                            <span class="inline-block bg-blue-500 text-white px-2 py-1 rounded">Approved</span>
                        @elseif ($ticket->isClosed())
                            <span class="inline-block bg-gray-500 text-black-50 px-2 py-1 rounded">Closed</span>
                        @endif </td>
                </tr>
            @endforeach </tbody>
        </table>
    </div>
    {{ $tickets->links() }}
</x-app-layout>
