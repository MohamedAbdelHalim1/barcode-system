<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('colors.index', compact('colors'));
    }

    public function show($id)
    {
        $Color = Color::findOrFail($id);
        return view('colors.show', compact('Color'));
    }

    public function create()
    {
        return view('colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:colors,key', // Validate key
        ]);
    
        // Get the last inserted color
        $lastColor = Color::orderBy('id', 'desc')->first();
    
        // Generate the new value
        $newValue = $lastColor ? str_pad((int)$lastColor->value + 1, 2, '0', STR_PAD_LEFT) : '01';
    
        // Create the color with the generated value
        Color::create([
            'key' => $request->key,
            'value' => $newValue,
        ]);
    
        return redirect()->route('colors.index')->with('success', 'Color created successfully!');
    }
    

    public function edit($id)
    {
        $Color = Color::findOrFail($id);
        return view('colors.edit', compact('Color'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:colors,key,' . $id, // Validate key
            'value' => 'required|string|max:255|unique:colors,value', // Validate value

        ]);

        $Color = Color::findOrFail($id);
        $Color->update($request->all());

        return redirect()->route('colors.index')->with('success', 'Color updated successfully!');
    }

    public function destroy($id)
    {
        $Color = Color::findOrFail($id);
        $Color->delete();

        return redirect()->route('colors.index')->with('success', 'Color deleted successfully!');
    }
}