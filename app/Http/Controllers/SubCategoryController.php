<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::all();
        return view('subcategories.index', compact('subcategories'));
    }

    public function show($id)
    {
        $SubCategory = SubCategory::findOrFail($id);
        return view('subcategories.show', compact('SubCategory'));
    }

    public function create()
    {
        return view('subcategories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:sub_categories,key', // Validate key
        ]);

        // Get the last inserted subcategory
        $lastSubCategory = SubCategory::orderBy('id', 'desc')->first();

        // Generate the new value
        $newValue = $lastSubCategory ? str_pad((int)$lastSubCategory->value + 1, 2, '0', STR_PAD_LEFT) : '01';

        // Create the subcategory with the generated value
        SubCategory::create([
            'key' => $request->key,
            'value' => $newValue,
        ]);

        return redirect()->route('subcategories.index')->with('success', 'SubCategory created successfully!');
    }


    public function edit($id)
    {
        $SubCategory = SubCategory::findOrFail($id);
        return view('subcategories.edit', compact('SubCategory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:sub_categories,key,' . $id, // Validate key
            'value' => 'required|string|max:255|unique:sub_categories,value', // Validate value

        ]);

        $SubCategory = SubCategory::findOrFail($id);
        $SubCategory->update($request->all());

        return redirect()->route('subcategories.index')->with('success', 'SubCategory updated successfully!');
    }

    public function destroy($id)
    {
        $SubCategory = SubCategory::findOrFail($id);
        $SubCategory->delete();

        return redirect()->route('subcategories.index')->with('success', 'SubCategory deleted successfully!');
    }
}