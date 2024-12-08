<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Item Line') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('itemlines.update', $ItemLine->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="key" class="block text-sm font-medium text-gray-700">Item Line Key</label>
                            <input type="text" name="key" id="key" class="form-control border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('key', $ItemLine->key) }}" required>
                            @error('key')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="value" class="block text-sm font-medium text-gray-700">Item Line Value</label>
                            <input type="text" name="value" id="value" class="form-control border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('value', $ItemLine->value) }}" required>
                            @error('value')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Item Line</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>