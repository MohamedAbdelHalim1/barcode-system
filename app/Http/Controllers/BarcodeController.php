<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Models\Size;
use App\Models\Store;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    // Index method to display barcodes
    public function index()
    {
        // Get barcodes for the authenticated user's store
        $barcodes = Barcode::where('store_id', auth()->user()->store_id)->get();
        
        return view('barcodes.index', compact('barcodes'));
    }

    // Create method to show the barcode form
    public function create()
    {
        // Get the authenticated user's store and sizes
        $store = auth()->user()->store; // Get the store associated with the authenticated user
        $sizes = Size::all(); // List all sizes
        
        return view('barcodes.create', compact('store', 'sizes'));
    }

    // Store method to save the barcode
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $request->validate([
                'store_id' => 'required|exists:stores,id',
                'category' => 'required|string',
                'sub_category' => 'required|string',
                'material' => 'required|string',
                'color' => 'required|string',
                'size_id' => 'required|exists:sizes,id',
            ]);

            // Generate SKU by concatenating inputs
            $store = $request->store_id;
            $category = str_pad($request->category, 3, '0', STR_PAD_LEFT); // Pad category to 3 digits
            $subCategory = str_pad($request->sub_category, 3, '0', STR_PAD_LEFT); // Pad sub_category to 3 digits
            $material = str_pad($request->material, 3, '0', STR_PAD_LEFT); // Pad material to 3 digits
            $color = str_pad($request->color, 3, '0', STR_PAD_LEFT); // Pad color to 3 digits
            $size = $request->size_id;
            
            // Concatenate inputs for SKU
            $sku = $store . $category . $subCategory . $material . $color . $size;

            // Ensure SKU is exactly 14 digits long
            if (strlen($sku) < 14) {
                $sku = str_pad($sku, 14, '0'); // Pad with zeros if the SKU is shorter than 14 digits
            }

            // Check if SKU already exists
            $existingBarcode = Barcode::where('sku', $sku)->first();
            if ($existingBarcode) {
                return redirect()->route('barcodes.index')
                    ->with('error', 'SKU already exists: ' . $sku)
                    ->with('existing_sku', $sku); // Pass the existing SKU to the session
            }
            // Get store name
            $storeName = Store::find($store)->pluck('name')->first(); // Get the store name from the first result

            // Save the barcode
            Barcode::create([
                'sku' => $sku,
                'title' => substr($storeName, 0, 2) . '-' . $sku,
                'size_id' => $size,
                'store_id' => $store,
            ]);

            return redirect()->route('barcodes.index')
                ->with('success', 'Barcode created successfully!');
        } catch (\Exception $e) {
            // If an exception occurs, show the error using dd()
            dd('Error occurred: ', $e->getMessage(), $e->getTraceAsString());
        }
    }



    // Destroy method to delete a barcode
    public function destroy(Barcode $barcode)
    {
        // Check if the authenticated user owns this store
        if ($barcode->store_id !== auth()->user()->store_id) {
            return redirect()->route('barcodes.index')
                ->with('error', 'You do not have permission to delete this barcode.');
        }

        // Delete the barcode
        $barcode->delete();

        return redirect()->route('barcodes.index')
            ->with('success', 'Barcode deleted successfully!');
    }


    public function updatePrice(Request $request)
    {
        $request->validate([
            'sku' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);
    
        $barcode = Barcode::where('sku', $request->sku)->first();
        if ($barcode) {
            $barcode->price = $request->price;
            $barcode->save();
            return response()->json(['success' => 'Price updated successfully']);
        }
    
        return response()->json(['error' => 'Barcode not found'], 404);
    }

    

    public function generateBarcode($sku)
        {
            $generator = new BarcodeGeneratorHTML();
            $barcode = $generator->getBarcode($sku, BarcodeGeneratorHTML::TYPE_CODE_128);

            return response()->json(['barcode' => $barcode]);
        }

}
