<?php

namespace App\Http\Controllers;

use App\Models\ItemLine;
use Illuminate\Http\Request;

class ItemLineController extends Controller
{
    public function index()
    {
        $ItemLines = ItemLine::all();
        return view('itemlines.index', compact('ItemLines'));
    }

    public function show($id)
    {
        $ItemLine = ItemLine::findOrFail($id);
        return view('itemlines.show', compact('ItemLine'));
    }

    public function create()
    {
        return view('itemlines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:item_lines,key', // Validate key
        ]);
    
        // Get the last inserted item line
        $lastItemLine = ItemLine::orderBy('id', 'desc')->first();
    
        // Generate the new value
        $newValue = $lastItemLine ? str_pad((int)$lastItemLine->value + 1, 2, '0', STR_PAD_LEFT) : '01';
    
        // Create the item line with the generated value
        ItemLine::create([
            'key' => $request->key,
            'value' => $newValue,
        ]);
    
        return redirect()->route('itemlines.index')->with('success', 'ItemLine created successfully!');
    }
    

    public function edit($id)
    {
        $ItemLine = ItemLine::findOrFail($id);
        return view('itemlines.edit', compact('ItemLine'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:item_lines,key,' . $id, // Validate key
            'value' => 'required|string|max:255|unique:item_lines,value', // Validate value

        ]);

        $ItemLine = ItemLine::findOrFail($id);
        $ItemLine->update($request->all());

        return redirect()->route('itemlines.index')->with('success', 'ItemLine updated successfully!');
    }

    public function destroy($id)
    {
        $ItemLine = ItemLine::findOrFail($id);
        $ItemLine->delete();

        return redirect()->route('itemlines.index')->with('success', 'ItemLine deleted successfully!');
    }
}