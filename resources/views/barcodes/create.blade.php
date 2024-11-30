<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl">Create Barcode</h1>
    </x-slot>

    <div class="container mx-auto my-8">
        <form method="POST" action="{{ route('barcodes.store') }}">
            @csrf

            <div class="form-group">
                <label for="store_id">Store</label>
                <!-- The input is readonly, showing the store name, but sending store_id in the request -->
                <input type="hidden" name="store_id" value="{{ $store->id }}">
                <input type="text" id="store_name" class="form-control border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ $store->name }}" readonly>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" class="form-control border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" maxlength="3" required>
            </div>

            <div class="form-group">
                <label for="sub_category">Sub Category</label>
                <input type="text" name="sub_category" id="sub_category" class="form-control border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" maxlength="3" required>
            </div>

            <div class="form-group">
                <label for="material">Material</label>
                <input type="text" name="material" id="material" class="form-control border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" maxlength="3" required>
            </div>

            <div class="form-group">
                <label for="color">Color</label>
                <input type="text" name="color" id="color" class="form-control border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" maxlength="3" required>
            </div>

            <div class="form-group">
                <label for="size_id">Size</label>
                <select name="size_id" id="size_id" class="form-control" required>
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->key }}</option>
                    @endforeach
                </select>
            </div>


            <button type="submit" class="btn btn-primary mt-2">Generate Barcode</button>
        </form>
    </div>
</x-app-layout>
