<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Store;
use App\Models\Season;
use App\Models\Barcode;
use App\Models\Category;
use App\Models\ItemLine;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorHTML;

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
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $colors = Color::all();
        $sizes = Size::all();
        $seasons = Season::all();
        $itemlines = ItemLine::all();

        
        return view('barcodes.create', compact('store', 'categories', 'subCategories', 'colors', 'sizes', 'seasons', 'itemlines'));
    }

    // Store method to save the barcode
    public function store(Request $request)
        {
            try {
                // Validate input
                $request->validate([
                    'store_id' => 'required|exists:stores,id',
                    'category_id' => 'required|string',
                    'category_key' => 'required|string',
                    'sub_category_id' => 'required|string',
                    'sub_category_key' => 'required|string',
                    'color_id' => 'required|string',
                    'color_key' => 'required|string',
                    'size_id' => 'required|string',
                    'size_key' => 'required|string',
                    'season_id' => 'required|string',
                    'season_key' => 'required|string',
                    'itemline_id' => 'required|string',
                    'itemline_key' => 'required|string',
                    'number_of_skus' => 'required|integer|min:1',
                ]);

                // Generate SKU components
                $store = $request->store_id;
                $category = str_pad($request->category_id, 2, '0', STR_PAD_LEFT);
                $subCategory = str_pad($request->sub_category_id, 2, '0', STR_PAD_LEFT);
                $color = str_pad($request->color_id, 2, '0', STR_PAD_LEFT);
                $size = str_pad($request->size_id, 2, '0', STR_PAD_LEFT);
                $season = str_pad($request->season_id, 2, '0', STR_PAD_LEFT);
                $itemline = str_pad($request->itemline_id, 2, '0', STR_PAD_LEFT);

                // Concatenate base SKU
                $baseSku = $store . $category . $subCategory . $color . $size . $season . $itemline;

                // Calculate remaining digits
                $remainingLength = 16 - strlen($baseSku);
                if ($remainingLength < 2) {
                    return back()->withErrors('Unable to generate SKUs. Base SKU too long.');
                }

                // Generate multiple SKUs
                $numberOfSkus = $request->number_of_skus;
                $storeName = Store::find($store)->name;

                for ($i = 1; $i <= $numberOfSkus; $i++) {
                    $uniquePart = str_pad((string) $i, $remainingLength, '0', STR_PAD_LEFT);
                    $sku = $baseSku . $uniquePart;

                    // Check if SKU already exists
                    if (Barcode::where('sku', $sku)->exists()) {
                        return back()->withErrors("SKU already exists: $sku");
                    }

                    // Concatenate keys for title and add unique part to make the title special
                    $title = $storeName . '-' . implode('-', [
                        $request->category_key,
                        $request->sub_category_key,
                        $request->color_key,
                        $request->size_key,
                        $request->season_key,
                        $request->itemline_key,
                    ]) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT); // Add the iteration number to make each title unique

                    // Save SKU
                    Barcode::create([
                        'sku' => $sku,
                        'title' => $title,
                        'store_id' => $store,
                    ]);
                }

                return redirect()->route('barcodes.index')->with('success', "$numberOfSkus barcodes created successfully!");
            } catch (\Exception $e) {
                dd($e->getMessage());
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
