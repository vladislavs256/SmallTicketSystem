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
                            return  "Status is " + full.status + '  <a href="/ticket/close/' + full.id + '">Close</a>';
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
                }            ],


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

