<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function index()
    {
        $Seasons = Season::all();
        return view('seasons.index', compact('Seasons'));
    }

    public function show($id)
    {
        $Season = Season::findOrFail($id);
        return view('seasons.show', compact('Season'));
    }

    public function create()
    {
        return view('seasons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:seasons,key', // Validate key
        ]);

        // Get the last inserted season
        $lastSeason = Season::orderBy('id', 'desc')->first();

        // Generate the new value
        $newValue = $lastSeason ? str_pad((int)$lastSeason->value + 1, 2, '0', STR_PAD_LEFT) : '01';

        // Create the season with the generated value
        Season::create([
            'key' => $request->key,
            'value' => $newValue,
        ]);

        return redirect()->route('seasons.index')->with('success', 'Season created successfully!');
    }


    public function edit($id)
    {
        $Season = Season::findOrFail($id);
        return view('seasons.edit', compact('Season'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:seasons,key,' . $id, // Validate key
            'value' => 'required|string|max:255|unique:seasons,value', // Validate value

        ]);

        $Season = Season::findOrFail($id);
        $Season->update($request->all());

        return redirect()->route('seasons.index')->with('success', 'Season updated successfully!');
    }

    public function destroy($id)
    {
        $Season = Season::findOrFail($id);
        $Season->delete();

        return redirect()->route('seasons.index')->with('success', 'Season deleted successfully!');
    }
}