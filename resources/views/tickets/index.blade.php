<x-app-layout>
    <div class="flex flex-wrap justify-center items-center space-between py-5">

        @if(!$user->isAdmin())
            <form method="GET" action="{{ route('tickets.create') }}">
                @csrf
                @method('GET')
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Create Ticket
                </button>
            </form>
        @else
            <form method="GET" action="{{ route('type.index') }}" class="inset-y-19 right-1/3  px-2">
                @csrf
                @method('GET')
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded d-flex ">Type
                    index
                </button>
            </form>
            <form method="GET" action="{{ route('type.create') }}" class="inset-y-8/2 right-1/4 ">
                @csrf
                @method('GET')
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded my-2">Create Type
                </button>
            </form>
        @endif
    </div>


    <div class="container mt-5 max-w-6xl mx-auto">
        <div class="table-responsive p-10 border-collapse flex justify-content-center rounded-3xl shadow-lg bg-gray-300/50">
            <div class="card w-full">
                <table id="tickets" class="text-center rounded-xl border-2  shadow-lg p-3">
                    <thead class="bg-gray-300/50 ">
                    <tr>
                        <th><a href="#" class="sort-link" data-column="id">ID</a></th>
                        <th><a href="#" class="sort-link" data-column="subject">Subject</a></th>
                        <th><a href="#" class="sort-link" data-column="content">Content</a></th>
                        <th>
                            <label for="type-filter">Filter by Type:</label>
                            <select id="type-filter">
                                <option value="">All</option>
                                @foreach($ticketTypes as $type)
                                    <option value="{{ $type->name }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <label for="status-filter">Sort By Status:</label>
                            <select id="status-filter">
                                <option value="">All</option>
                                <option value="new">New</option>
                                <option value="in progress">In progress</option>
                                <option value="closed">Closed</option>
                            </select>
                        </th>
                        <th><a href="#" class="sort-link" data-column="created">Created</a></th>
                        <th><a href="#" class="sort-link" data-column="updated">Updated</a></th>
                        <th><a href="#" class="sort-link" data-column="status" onclick="loadData()">Link</a></th>

                        @if($user->isAdmin())
                            <th><a href="#" class="sort-link" data-column="updated">Comment</a></th>
                        @endif
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        const isAdmin = {{ Auth::user()->isAdmin() ? 'true' : 'false' }};
        const columns = isAdmin
            ? [
                {"data": "id"},
                {"data": "subject"},
                {"data": "content"},
                {
                    "data": "type_name",
                    orderable: false,
                },
                {
                    "data": "status",
                    orderable: false,
                    "render": function (data, type, full, meta) {
                        if (data !== 'closed') {
                            return 'Status ' + data + ' <button class="btn-close" data-ticket-id="' + full.id + '">Close Ticket</button>';
                        } else {
                            return ' Status is ' + data + '  <button class="btn-reopen" data-ticket-id="' + full.id + '">Click to Reopen</button>';
                        }
                    }
                },
                {"data": "created_at"},
                {"data": "updated_at"},

                {
                    "data": "link",
                    "orderable": false,
                    "render": function (data) {
                        return '<a href="' + data + '">' + "View" + '</a>';
                    }
                },
                {
                    "data": "id",
                    "orderable": false,
                    "render": function (data, type, row) {
                        if (row.status === 'closed') {
                            return 'Closed';
                        } else {
                            return '<div class="hidden" id="comment-form-' + data + '">' +
                                '<form class="space-x-2">' +
                                '<input type="text" placeholder="Send Message" class="border border-gray-300 px-2 py-1 rounded">' +
                                '<button type="submit" class="bg-green-500 text-white px-2 py-1 rounded" id="submit-comment-' + data + '">Send</button>' +
                                '<button type="button" class="bg-red-500 text-white px-2 py-1 rounded" id="cancel-comment-' + data + '">Cancel</button>' +
                                '</form>' +
                                '</div>' + '<button class="btn-comment" data-ticket-id="' + data + '">Comment</button>';
                        }
                    }
                }
            ]
            : [
                {"data": "id"},
                {"data": "subject"},
                {"data": "content"},
                {
                    "data": "type_name",
                    orderable: false,
                },
                {
                    "data": "status",
                    orderable: false
                },
                {"data": "created_at"},
                {"data": "updated_at"},
                {
                    "data": "link",
                    "orderable": false,
                    "render": function (data) {
                        return '<a href="' + data + '">' + "View" + '</a>';
                    }
                },
            ];
        table = $('#tickets').DataTable({

            "ajax": {
                "url": "/tickets/data",
                "type": "GET",
            },
            "columns": columns,


        });

        $('#tickets').on('click', '.btn-close', function () {
            var ticketId = $(this).data('ticket-id');

            $.ajax({
                type: 'POST',
                url: '/ticket/close/' + ticketId,
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                    console.log('Ticket closed successfully');
                    table.ajax.reload();
                },
                error: function (error) {
                    console.error('Error closing ticket:', error);
                }
            });
        });

        $('#tickets').on('click', '.btn-comment', function () {
            var ticketId = $(this).data('ticket-id');
            $('#comment-form-' + ticketId).removeClass('hidden');
        });
        $('#tickets').on('click', '[id^=cancel-comment-]', function () {
            var ticketId = $(this).attr('id').split('-')[2];
            $('#comment-form-' + ticketId).addClass('hidden');
        });
        $('#tickets').on('click', '[id^=submit-comment-]', function (e) {
            e.preventDefault();
            var ticketId = $(this).attr('id').split('-')[2];
            var comment = $(this).closest('div[id^=comment-form-]').find('input').val();

            $.ajax({
                type: 'POST',
                url: '/admin/tickets/message/' + ticketId,
                data: {
                    _token: '{{ csrf_token() }}',
                    message: comment,
                },
                success: function (data) {
                    alert('Ticket message send successfully');
                    table.ajax.reload();
                },
                error: function (error) {
                    alert("Message not sent check console ");
                    console.error('Error send message ticket:', error);
                }
            });
        });

        $('#tickets').on('click', '.btn-reopen', function () {
            var ticketId = $(this).data('ticket-id');

            $.ajax({
                type: 'POST',
                url: '/ticket/reopen/' + ticketId,
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                    console.log('Ticket reopen successfully');
                    table.ajax.reload();
                },
                error: function (error) {
                    console.error('Error closing ticket:', error);
                }
            });
        });

        function applyFilterType(selectedType) {
            table.column(3).search(selectedType).draw();
        }

        $('#type-filter').on('change', function () {
            var selectedType = $(this).val();
            applyFilterType(selectedType);
        });

        function applyFilterStatus(selectedStatus) {
            table.column(4).search(selectedStatus).draw();
        }

        $('#status-filter').on('change', function () {
            var selectedStatus = $(this).val();
            applyFilterStatus(selectedStatus);
        });

    });
</script>

