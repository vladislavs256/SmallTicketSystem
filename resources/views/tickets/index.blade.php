<x-app-layout>
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

                <th><a href="#" class="sort-link" data-column="created">Created</a></th>
                <th><a href="#" class="sort-link" data-column="updated">Updated</a></th>
                <th><a href="#" class="sort-link" data-column="status">Status</a></th>

                <th><a href="#" class="sort-link" data-column="status" onclick="loadData()">Link</a></th>
                <th><a href="#" class="sort-link" data-column="updated">Comment</a></th>

            </tr>
            </thead>

        </table>
    </div>
    {{ $tickets->links() }}
</x-app-layout>



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
       table = $('#tickets').DataTable({
            "ajax": {
                "url": "/tickets/data",
                "type": "GET",
            },
            "columns": [
                { "data": "id" },
                { "data": "subject" },
                { "data": "content" },
                { "data": "type_name",
                orderable: false,
                },
                { "data": "created_at" },
                { "data": "updated_at" },
                {
                    "data": "status",
                    "render": function(data, type, full, meta) {
                        if (data !== 'closed') {
                            return 'Status is '+ data + ' <button class="btn-close" data-ticket-id="' + full.id + '">Close Ticket</button>';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    // Use columns.render to create a custom cell content with an <a> element
                    "data": "link",
                    "orderable": false,
                    "render": function(data, type, row) {
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
                            return `
                <button class="btn-comment" data-ticket-id="${data}">Comment</button>
            `;
                        }
                    }
                }
            ],


        });

        $('#tickets').on('click', '.btn-close', function() {
            var ticketId = $(this).data('ticket-id');

            $.ajax({
                type: 'POST',
                url: '/ticket/close/' + ticketId, // Replace with the actual URL to close the ticket
                data: {
                    _token: '{{ csrf_token() }}', // Include CSRF token for Laravel
                },
                success: function(data) {
                    // Handle the success response here, e.g., update the UI
                    console.log('Ticket closed successfully');

                    // Reload the DataTable to reflect the updated data
                    table.ajax.reload();
                },
                error: function(error) {
                    // Handle any errors here
                    console.error('Error closing ticket:', error);
                }
            });
        });

        function applyFilter(selectedType) {
            table.column(3).search(selectedType).draw();
        }

        $('#type-filter').on('change', function () {
            var selectedType = $(this).val();
            applyFilter(selectedType);
        });


    });
</script>

