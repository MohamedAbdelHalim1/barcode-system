<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Item Line Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-medium text-lg">Item Line Key: {{ $itemline->key }}</h3>

                    <div class="mt-4">
                        <a href="{{ route('itemlines.edit', $itemline->id) }}" class="btn btn-warning">Edit Item Line</a>
                        <form action="{{ route('itemlines.destroy', $itemline->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item line?')">Delete Item Line</button>
                        </form>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('itemlines.index') }}" class="btn btn-primary">Back to Item Lines</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>