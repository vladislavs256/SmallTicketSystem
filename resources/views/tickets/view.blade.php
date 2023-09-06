<x-app-layout>
    <div class="flex flex-row mb-3">
        @if ($ticket->canBeRemoved())

            <form method="POST" action="{{ route('ticket.destroy', $ticket) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
            </form>
            <form method="POST" action="{{ route('ticket.close', ['ticket' => $ticket]) }}">
                @csrf
                @method('POST')
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Close</button>

            </form>

        @endif
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-5">
            <table class="table-auto border-collapse border border-gray-300">
                <tbody>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">ID</th>
                    <td class="border border-gray-300 py-2 px-4">{{ $ticket->id }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Created</th>
                    <td class="border border-gray-300 py-2 px-4">{{ $ticket->created_at }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Updated</th>
                    <td class="border border-gray-300 py-2 px-4">{{ $ticket->updated_at }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Status</th>
                    <td class="border border-gray-300 py-2 px-4">
                        @if ($ticket->isOpen())
                            <span class="bg-red-500 text-white py-1 px-2 rounded">New</span>
                        @elseif ($ticket->isApproved())
                            <span class="bg-blue-500 text-white py-1 px-2 rounded">Progress</span>
                        @elseif ($ticket->isClosed())
                            <span class="bg-gray-500 text-black-50 py-1 px-2 rounded">Closed</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Type</th>
                    <td class="border border-gray-300 py-2 px-4">{{ $ticket->typeName() }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Author</th>
                    <td class="border border-gray-300 py-2 px-4">{{ $ticket->user->name }}</td>
                </tr>
                <tr>
                    @if($ticket->getAttachments()->count() > 0)
                        @foreach($ticket->getAttachments() as $attachment)
                            <th class="border border-gray-300 py-2 px-4">Files</th>

                            <td class="border border-gray-300 py-2 px-4">
                                <ul>
                                    <li>
                                        Name: {{ $attachment->filename }},
                                        <a href="{{ Storage::url($attachment->path)  }}">View link</a>,
                                        ID: {{ $attachment->id }}
                                        <a href="{{ Storage::url($attachment->path) }}"
                                           download="{{$attachment->name}}.jpg">Download Attachment</a>
                                    </li>
                                </ul>

                            </td>
                </tr>

                @endforeach
                @else
                    No attachments found.
                @endif
                </tbody>
            </table>
        </div>
        <div class="mb-5">
            <table class="table-auto border-collapse border border-gray-300">
                <thead>
                <tr>
                    <th class="border border-gray-300 py-2 px-4">Date</th>
                    <th class="border border-gray-300 py-2 px-4">User</th>
                    <th class="border border-gray-300 py-2 px-4">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($ticket->statuses()->orderBy('id')->with('user')->get() as $status)
                    <tr>
                        <td class="border border-gray-300 py-2 px-4">{{ $status->created_at }}</td>
                        <td class="border border-gray-300 py-2 px-4">{{ $status->user->name }}</td>
                        <td class="border border-gray-300 py-2 px-4">
                            @if ($status->isOpen())
                                <span class="bg-red-500 text-white py-1 px-2 rounded">New</span>
                            @elseif ($status->isApproved())
                                <span class="bg-blue-500 text-white py-1 px-2 rounded">Progress</span>
                            @elseif ($status->isClosed())
                                <span class="bg-gray-500 text-black-50 py-1 px-2 rounded">Closed</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mb-5">
        <div class="bg-gray-200 py-2 px-4 text-xl font-semibold">{{ $ticket->subject }}</div>
        <div class="bg-white border border-gray-300 p-4">
            {!! nl2br(e($ticket->content)) !!}
        </div>
    </div>

    @foreach ($ticket->messages()->orderBy('id')->with('user')->get() as $message)
        <div class="mb-5">
            <div class="bg-gray-200 py-2 px-4 text-xl font-semibold">{{ $message->created_at }}
                by {{ $message->user->name }}</div>
            <div class="bg-white border border-gray-300 p-4">
                {!! nl2br(e($message->message)) !!}
            </div>
        </div>
    @endforeach
    <div id="commentsContainer">
    </div>
    @if ($ticket->allowsMessages())
        <form id="messageForm" action="{{ route('admin.tickets.message', $ticket) }}" method="POST">
            @csrf
            <div class="mb-5">
                <label>
                    <textarea
                        class="w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        name="message" rows="3" required>{{ old('message') }}</textarea>
                </label>
                @if ($errors->has('message'))
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('message') }}</p>
                @endif
            </div>

            <div class="mb-5">
                <button type="button" id="sendMessageButton"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Send Message
                </button>
            </div>
        </form>

    @endif
    <div id="messageContainer">
    </div>


</x-app-layout>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const messageForm = document.getElementById("messageForm");
        const sendMessageButton = document.getElementById("sendMessageButton");
        const messageContainer = document.getElementById("messageContainer");

        sendMessageButton.addEventListener("click", function () {
            const formData = new FormData(messageForm);

            axios.post(messageForm.action, formData)
                .then(function (response) {
                    console.log("Message sent successfully");
                    const newMessage = document.createElement("div");
                    messageContainer.appendChild(newMessage);
                    messageForm.reset();
                    fetchComments();
                })
                .catch(function (error) {
                    if (error.response && error.response.data && error.response.data.error) {
                        const errorMessage = error.response.data.error;
                        console.error("Error sending message:", errorMessage);
                        alert("Error sending message: " + errorMessage);
                    } else {
                        console.error("Error sending message:", error);
                    }
                });

        });

        function fetchComments() {
            axios.post('/messages/{{$ticket->id}}')
                .then(function (response) {
                    const commentsContainer = document.getElementById("commentsContainer");
                    const newMessage = document.createElement("div");
                    newMessage.innerHTML = response.data;
                    commentsContainer.appendChild(newMessage);
                })
                .catch(function (error) {
                    console.error("Error sending message:", error);
                });
        }
    });


</script>
