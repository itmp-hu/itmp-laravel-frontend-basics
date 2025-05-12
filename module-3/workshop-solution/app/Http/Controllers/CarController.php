<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    function store(Request $request) {

        //TODO: validate
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_production' => 'required|integer|min:1900|max:' . date('Y'),
            'class' => 'required|string|max:255',
            'image' => 'url'
        ]);

        $car = Car::create($validated);

        return redirect()->route('cars.create')->with('success', 'Car created successfully.');
    }

    function destroy($id) {
        $car = Car::find($id);
        if (!$car) {
            return redirect()->route('cars.index')->with('error', 'No car found.');
        }

        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Car deleted successfully.');

    }

    public function edit(string $id)
    {
        $car = Car::find($id);
        return view('edit', ['car' => $car]);
    }

    public function update(Request $request, string $id)
{
    $car = Car::find($id);
    
    $validated = $request->validate([
        'image' => 'required|url',
        'title' => 'required|string|max:255',
        'start_production' => 'required|integer|min:1886|max:' . date('Y'),
        'class' => 'required|string|max:255',
    ]);

    $car->update($validated);

    return redirect()->route('cars.index')->with('success', 'Car updated successfully!');
}
}
