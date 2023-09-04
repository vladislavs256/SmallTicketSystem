        <div class="mb-5">
            <div class="bg-gray-200 py-2 px-4 text-xl font-semibold">{{ $message->created_at }} by {{ $message->user->name }}</div>
            <div class="bg-white border border-gray-300 p-4">
                {!! nl2br(e($message->message)) !!}
            </div>
        </div>


