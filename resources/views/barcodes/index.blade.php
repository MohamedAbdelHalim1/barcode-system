<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl">Barcodes</h1>
    </x-slot>

    <div class="container mx-auto my-8">
        @if(session('success'))
            <div class="alert alert-success relative">
                <span>{{ session('success') }}</span>
                <button type="button" class="absolute top-0 right-0 p-2 text-gray-600" onclick="this.parentElement.style.display='none';">
                    <span>&times;</span>
                </button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger relative">
                <span>{{ session('error') }}</span>
                <button type="button" class="absolute top-0 right-0 p-2 text-gray-600" onclick="this.parentElement.style.display='none';">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <a href="{{ route('barcodes.create') }}" class="btn btn-primary mb-3">Create Barcode</a>
        <!-- Export to CSV Button -->
        <a href="javascript:void(0);" class="btn btn-secondary mb-3" onclick="exportToCSV()">Export to CSV</a>


        <table id="barcodesTable" class="table w-full mt-4">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barcodes as $barcode)
                    <tr id="barcode-{{ $barcode->sku }}">
                        <td>{{ $barcode->title }}</td>
                        <td>{{ $barcode->sku }}</td>
                        <td id="price-{{ $barcode->sku }}">{{ $barcode->price ?? 'N/A' }}</td>
                        <td>
                            <!-- Add Price Button -->
                            <button class="btn btn-info btn-sm" onclick="promptForPrice('{{ $barcode->sku }}')">Add Price</button>
                            
                            <!-- Print Barcode Button -->
                            <button class="btn btn-primary btn-sm" onclick="printBarcode('{{ $barcode->sku }}')">Print Barcode</button>

                            <!-- Delete Button -->
                            <form action="{{ route('barcodes.destroy', $barcode) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Barcode?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableToCSV/0.1.0/tableToCSV.min.js"></script>

    <!-- DataTables Initialization Script -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#barcodesTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthChange": true,
            });
              // Check if the session has 'existing_sku' and filter
            @if (session('existing_sku'))
                var existingSku = '{{ session('existing_sku') }}';
                table.search(existingSku).draw(); // Apply filter to the DataTable
            @endif
        });

        // Prompt for Price Input and Update
        function promptForPrice(sku) {
            var price = prompt('Enter the price for barcode SKU ' + sku);

            // Check if price is a valid number
            if (price !== null && !isNaN(price) && price >= 0) {
                updatePrice(sku, price);
            } else {
                alert('Invalid price entered!');
            }
        }

        // Update Price via AJAX
        function updatePrice(sku, price) {
            $.ajax({
                url: '/barcodes/updatePrice',
                type: 'PUT',
                data: {
                    sku: sku,
                    price: price,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update price in the table without refreshing
                    $('#price-' + sku).text(price);
                    alert('Price updated successfully!');
                },
                error: function() {
                    alert('Failed to update the price.');
                }
            });
        }

        // Print Barcode
        function printBarcode(sku) {
            // Fetch the barcode HTML from the backend
            $.ajax({
                url: '/barcodes/generate/' + sku,
                type: 'GET',
                success: function(response) {
                    var printWindow = window.open('', '', 'width=800,height=600');
                    printWindow.document.write('<html><head><title>Print Barcode</title></head><body>');
                    printWindow.document.write('<h3>Barcode for SKU: ' + sku + '</h3>');
                    printWindow.document.write(response.barcode);  // This contains the barcode HTML
                    printWindow.document.write('<button onclick="window.print()">Print</button>');
                    printWindow.document.write('</body></html>');
                    printWindow.document.close();
                },
                error: function() {
                    alert('Failed to generate barcode.');
                }
            });
        }

         // Function to export table data to CSV
         function exportToCSV() {
            var table = document.getElementById('barcodesTable');
            var rows = table.rows;
            var csv = [];

            // Loop through the rows and extract data
            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                var rowData = [];
                
                // Loop through the columns (cells) in each row
                for (var j = 0; j < row.cells.length; j++) {
                    if (j !== 3) { // Skip the last column (Actions column)
                        rowData.push(row.cells[j].innerText.replace(/,/g, '')); // Remove commas from data
                    }
                }
                csv.push(rowData.join(',')); // Join row data with commas
            }

            // Create CSV file content
            var csvContent = csv.join('\n');

            // Create a temporary download link and trigger the download
            var hiddenElement = document.createElement('a');
            hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csvContent);
            hiddenElement.target = '_blank';
            hiddenElement.download = 'barcodes.csv';
            hiddenElement.click();
        }
    </script>
</x-app-layout>
