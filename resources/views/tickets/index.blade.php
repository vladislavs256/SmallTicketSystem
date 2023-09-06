<x-app-layout>

    @if(!$user->isAdmin())
    <form method="GET" action="{{ route('tickets.create') }}">
        @csrf
        @method('GET')
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Create Ticket</button>

    </form>
        @else
            <form method="GET" action="{{ route('type.index') }}">
                @csrf
                @method('GET')
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Type index</button>

            </form>
        <form method="GET" action="{{ route('type.create') }}">
            @csrf
            @method('GET')
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded my-2">Create Type</button>

        </form>
    @endif

    <div  class="flex justify-center px-2" style="padding-top: 50px"> <!-- Ticket System Container -->
        <table id="tickets" class="w-full max-w-200 table-auto" style="max-width: 50%; ">
            <thead>
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


                @if($user->isAdmin())

                    <th><a href="#" class="sort-link" data-column="status" onclick="loadData()">Link</a></th>
                    <th><a href="#" class="sort-link" data-column="updated">Comment</a></th>
                @endif


            </tr>
            </thead>

        </table>
    </div>
</x-app-layout>


<!-- Comment Modal -->
<div class="container">

<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true" style="top: 50%; transform: translateY(-50%)">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Add Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="commentForm">
                    @csrf
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitComment">Submit Comment</button>
            </div>
        </div>
    </div>
</div>
</div>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        const isAdmin = {{ Auth::user()->isAdmin() ? 'true' : 'false' }};
        const columns = isAdmin
            ? [
                { "data": "id" },
                { "data": "subject" },
                { "data": "content" },
                { "data": "type_name",
                    orderable: false,
                },
                {
                    "data": "status",
                    orderable: false,
                    "render": function(data, type, full, meta) {
                        if (data !== 'closed') {
                            return 'Status '+ data + ' <button class="btn-close" data-ticket-id="' + full.id + '">Close Ticket</button>';
                        } else {
                            return ' Status is ' + data + '  <button class="btn-reopen" data-ticket-id="' + full.id + '">Click to Reopen</button>' ;
                        }
                    }
                },
                { "data": "created_at" },
                { "data": "updated_at" },

                {
                    "data": "link",
                    "orderable": false,
                    "render": function(data) {
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
                            return '<button class="btn-comment" data-ticket-id="' + data  +'">Comment</button>';
                            }
                        }
                    }
            ]
            : [
                { "data": "id" },
                { "data": "subject" },
                { "data": "content" },
                { "data": "type_name",
                    orderable: false,
                },
                {"data": "status",
                orderable: false},
                { "data": "created_at" },
            ];
        table = $('#tickets').DataTable({
            "ajax": {
                "url": "/tickets/data",
                "type": "GET",
            },
            "columns": columns,


        });

        $('#tickets').on('click', '.btn-close', function() {
            var ticketId = $(this).data('ticket-id');

            $.ajax({
                type: 'POST',
                url: '/ticket/close/' + ticketId,
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    console.log('Ticket closed successfully');
                    table.ajax.reload();
                },
                error: function(error) {
                    console.error('Error closing ticket:', error);
                }
            });
        });

        $('#tickets').on('click', '.btn-comment', function() {
            var ticketId = $(this).data('ticket-id');

            // Set the ticketId in the comment modal for reference
            $('#commentModal').data('ticket-id', ticketId);

            // Open the comment modal
            $('#commentModal').modal('show');
        });


        $('#tickets').on('click', '.btn-reopen', function() {
            var ticketId = $(this).data('ticket-id');

            $.ajax({
                type: 'POST',
                url: '/ticket/reopen/' + ticketId,
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    console.log('Ticket reopen successfully');
                    table.ajax.reload();
                },
                error: function(error) {
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

