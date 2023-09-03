<x-app-layout>
    <div  class="flex justify-center px-2" style="padding-top: 50px"> <!-- Ticket System Container -->
        <table id="tickets" class="w-full max-w-200 table-auto" style="max-width: 50%; ">
            <thead>
            <tr>
                <th><a href="#" class="sort-link" data-column="id">ID</a></th>
                <th><a href="#" class="sort-link" data-column="subject">Subject</a></th>
                <th><a href="#" class="sort-link" data-column="content">Content</a></th>
                <th><a href="#" class="sort-link" data-column="type">Type</a></th>
                <th><a href="#" class="sort-link" data-column="created">Created</a></th>
                <th><a href="#" class="sort-link" data-column="updated">Updated</a></th>
                <th><a href="#" class="sort-link" data-column="status">Status</a></th>
            </tr>

            </thead>
{{--            <tbody> @foreach ($tickets as $ticket)--}}
{{--                <tr>--}}
{{--                    <td class="border px-4 py-2">{{ $ticket->id }}</td>--}}
{{--                    <td class="border px-4 py-2">{{ $ticket->subject }}</td>--}}
{{--                    <td class="border px-4 py-2">{{ $ticket->content }}</td>--}}
{{--                    <td class="border px-4 py-2">{{ $ticket->type_id }}</td>--}}
{{--                    <td class="border px-4 py-2">{{ $ticket->created_at }}</td>--}}
{{--                    <td class="border px-4 py-2">{{ $ticket->updated_at }}</td>--}}
{{--                    <td class="border px-4 py-2">--}}
{{--                        @if ($ticket->isOpen())--}}
{{--                            <span class="inline-block bg-red-500 text-white px-2 py-1 rounded">Open</span>--}}
{{--                        @elseif ($ticket->isApproved())--}}
{{--                            <span class="inline-block bg-blue-500 text-white px-2 py-1 rounded">Approved</span>--}}
{{--                        @elseif ($ticket->isClosed())--}}
{{--                            <span class="inline-block bg-gray-500 text-black-50 px-2 py-1 rounded">Closed</span>--}}
{{--                        @endif </td>--}}
{{--                </tr>--}}
{{--            @endforeach </tbody>--}}
        </table>
    </div>
    {{ $tickets->links() }}
</x-app-layout>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https:////cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $('#tickets').DataTable({
            "ajax": {
                "url": "/tickets/data",
                "type": "GET",
            },
            "columns": [
                { "data": "id" },
                { "data": "subject" },
                { "data": "content" },
                { "data": "type_name" },
                { "data": "created_at" },
                { "data": "updated_at" },
                { "data": "status" },
            ],
        });
    });
</script>
