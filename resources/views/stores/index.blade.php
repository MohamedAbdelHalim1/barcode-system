<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stores List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Store Management Section -->
            <div class="bg-white shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <!-- Create Store Button -->
                    <div class="d-flex justify-content-between mb-4">
                        <a href="{{ route('stores.create') }}" class="btn btn-primary">Add Store</a>
                    </div>

                    <!-- Store Data Table -->
                    <div class="table-responsive">
                        <table id="storesTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stores as $store)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $store->name }}</td>
                                    <td>
                                        <a href="{{ route('stores.show', $store->id) }}" class="btn btn-sm btn-info">Show</a>
                                        <a href="{{ route('stores.edit', $store->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('stores.destroy', $store->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this store?')">Delete</button>
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
    </div>

    <script>
        $(document).ready(function() {
            $('#storesTable').DataTable();
        });
    </script>
    

</x-app-layout>
