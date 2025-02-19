<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:categories,key', // Validate key
        ]);

        // Get the last inserted category
        $lastCategory = Category::orderBy('id', 'desc')->first();

        // Generate the new value
        $newValue = $lastCategory ? str_pad((int)$lastCategory->value + 1, 2, '0', STR_PAD_LEFT) : '01';

        // Create the category with the generated value
        Category::create([
            'key' => $request->key,
            'value' => $newValue,
        ]);


        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:categories,key,' . $id, // Validate key
            'value' => 'required|string|max:255|unique:categories,value', // Validate value

        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}