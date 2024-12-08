<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Season Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-medium text-lg">Season Key: {{ $season->key }}</h3>
                    <p class="mt-2">Season Value: {{ $season->value }}</p>

                    <div class="mt-4">
                        <a href="{{ route('seasons.edit', $season->id) }}" class="btn btn-warning">Edit Season</a>
                        <form action="{{ route('seasons.destroy', $season->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this season?')">Delete Season</button>
                        </form>
                        <a href="{{ route('seasons.index') }}" class="btn btn-primary mt-4">Back to Seasons</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>