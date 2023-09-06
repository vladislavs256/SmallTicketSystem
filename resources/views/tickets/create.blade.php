<x-app-layout>
    <form method="POST" action="{{ route('ticket.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="subject" class="block text-gray-700">Subject</label>
            <input id="subject"
                   class="w-full px-4 py-2 rounded-lg border {{ $errors->has('subject') ? 'border-red-500' : 'border-gray-300' }}"
                   name="subject" value="{{ old('subject') }}" required>
            @if ($errors->has('subject'))
                <p class="text-red-500 text-sm mt-1"><strong>{{ $errors->first('subject') }}</strong></p>
            @endif
        </div>

        <div class="mb-4">
            <label for="content" class="block text-gray-700">Content</label>
            <textarea id="content"
                      class="w-full px-4 py-2 rounded-lg border {{ $errors->has('content') ? 'border-red-500' : 'border-gray-300' }}"
                      name="content" rows="10" required>{{ old('content') }}</textarea>
            @if ($errors->has('content'))
                <p class="text-red-500 text-sm mt-1"><strong>{{ $errors->first('content') }}</strong></p>
            @endif
        </div>

        <div class="mb-4">
            <label for="type" class="block text-gray-700">Type</label>
            <select id="type"
                    class="w-full px-4 py-2 rounded-lg border {{ $errors->has('type') ? 'border-red-500' : 'border-gray-300' }}"
                    name="type" required>
                <option value="">Select a Type</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('type'))
                <p class="text-red-500 text-sm mt-1"><strong>{{ $errors->first('type') }}</strong></p>
            @endif
        </div>
        <div class="mb-4">
            <label for="attachments" class="block text-gray-700">Attachments</label>
            <input id="attachments" type="file"
                   class="w-full px-4 py-2 rounded-lg border {{ $errors->has('attachments') ? 'border-red-500' : 'border-gray-300' }}"
                   name="attachments[]" multiple>
            @if ($errors->has('attachments'))
                <p class="text-red-500 text-sm mt-1"><strong>{{ $errors->first('attachments') }}</strong></p>
            @endif
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Save</button>
        </div>
    </form>
</x-app-layout>
