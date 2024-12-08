<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Item Lines List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('itemlines.create') }}" class="btn btn-primary mb-4" style="margin-left: 55px;">Create New Item Line</a>
                    <table class="table table-bordered" style="width:90%;margin:auto;">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ItemLines as $itemline)
                                <tr>
                                    <td>{{ $itemline->key }}</td>
                                    <td>{{ $itemline->value }}</td>

                                    <td>
                                        <a href="{{ route('itemlines.show', $itemline->id) }}" class="btn btn-sm btn-info">Show</a>
                                        <a href="{{ route('itemlines.edit', $itemline->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('itemlines.destroy', $itemline->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item line?')">Delete</button>
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