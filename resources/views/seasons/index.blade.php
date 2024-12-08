<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seasons List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('seasons.create') }}" class="btn btn-primary mb-4" style="margin-left: 55px;">Create New Season</a>
                    <table class="table table-bordered" style="width:90%;margin:auto;">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Seasons as $season)
                                <tr>
                                    <td>{{ $season->key }}</td>
                                    <td>{{ $season->value }}</td>
                                    <td>
                                        <a href="{{ route('seasons.show', $season->id) }}" class="btn btn-sm btn-info">Show</a>
                                        <a href="{{ route('seasons.edit', $season->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('seasons.destroy', $season->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this season?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
</x-app-layout>