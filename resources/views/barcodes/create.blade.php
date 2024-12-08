<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl">Create Barcode</h1>
    </x-slot>

    <div class="container mx-auto my-8 flex space-x-8">
        <!-- Left Section: Input Fields -->
        <div class="w-1/2 border-r pr-4">
            <form id="barcodeForm" method="POST" action="{{ route('barcodes.store') }}">
                @csrf
                <div class="form-group">
                    <label for="store_id">Store</label>
                    <input type="hidden" name="store_id" value="{{ $store->id }}">
                    <input type="text" id="store_name" class="form-control border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ $store->name }}" readonly>
                    <input type="hidden" name="store_key" value="{{ $store->name }}">
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Choose Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->value }}" data-key="{{ $category->key }}">{{ $category->key }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="category_key" id="category_key">
                </div>

                <div class="form-group">
                    <label for="sub_category_id">Sub Category</label>
                    <select name="sub_category_id" id="sub_category_id" class="form-control" required>
                        <option value="">Choose Sub Category</option>
                        @foreach ($subCategories as $subCategory)
                            <option value="{{ $subCategory->value }}" data-key="{{ $subCategory->key }}">{{ $subCategory->key }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="sub_category_key" id="sub_category_key">
                </div>

                <div class="form-group">
                    <label for="color_id">Color</label>
                    <select name="color_id" id="color_id" class="form-control" required>
                        <option value="">Choose Color</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color->value }}" data-key="{{ $color->key }}">{{ $color->key }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="color_key" id="color_key">
                </div>

                <div class="form-group">
                    <label for="size_id">Size</label>
                    <select name="size_id" id="size_id" class="form-control" required>
                        <option value="">Choose Size</option>
                        @foreach ($sizes as $size)
                            <option value="{{ $size->value }}" data-key="{{ $size->key }}">{{ $size->key }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="size_key" id="size_key">
                </div>

                <div class="form-group">
                    <label for="season_id">Season</label>
                    <select name="season_id" id="season_id" class="form-control" required>
                        <option value="">Choose Season</option>
                        @foreach ($seasons as $season)
                            <option value="{{ $season->value }}" data-key="{{ $season->key }}">{{ $season->key }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="season_key" id="season_key">
                </div>

                <div class="form-group">
                    <label for="itemline_id">Item Line</label>
                    <select name="itemline_id" id="itemline_id" class="form-control" required>
                        <option value="">Choose Item Line</option>
                        @foreach ($itemlines as $itemline)
                            <option value="{{ $itemline->value }}" data-key="{{ $itemline->key }}">{{ $itemline->key }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="itemline_key" id="itemline_key">
                </div>
            </form>
        </div>

        <!-- Right Section: Number of SKUs -->
        <div class="w-1/2 pl-4">
            <h2 class="text-lg mb-4">Generate Multiple SKUs</h2>
            <div class="form-group">
                <label for="number_of_skus">Number of SKUs</label>
                <input type="number" id="number_of_skus" name="number_of_skus" class="form-control border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" form="barcodeForm" required min="1">
            </div>
            <button type="submit" form="barcodeForm" class="btn btn-primary mt-4">Create Barcodes</button>
        </div>
    </div>

    <script>
        // JavaScript to capture the selected options and set the corresponding hidden keys
        document.getElementById('category_id').addEventListener('change', function () {
            document.getElementById('category_key').value = this.options[this.selectedIndex].getAttribute('data-key');
        });

        document.getElementById('sub_category_id').addEventListener('change', function () {
            document.getElementById('sub_category_key').value = this.options[this.selectedIndex].getAttribute('data-key');
        });

        document.getElementById('color_id').addEventListener('change', function () {
            document.getElementById('color_key').value = this.options[this.selectedIndex].getAttribute('data-key');
        });

        document.getElementById('size_id').addEventListener('change', function () {
            document.getElementById('size_key').value = this.options[this.selectedIndex].getAttribute('data-key');
        });

        document.getElementById('season_id').addEventListener('change', function () {
            document.getElementById('season_key').value = this.options[this.selectedIndex].getAttribute('data-key');
        });

        document.getElementById('itemline_id').addEventListener('change', function () {
            document.getElementById('itemline_key').value = this.options[this.selectedIndex].getAttribute('data-key');
        });
    </script>
</x-app-layout>
