<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredients;

class IngredientsController extends Controller
{
    public function update(Request $request, $id)
    {
    $ingredients = Ingredients::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ]);

    $ingredients->name = $request->name;
    $ingredients->price = $request->price;

    $ingredients->save();

    return redirect()->route('admin.ingredients')->with('success', 'ingredient bol upravený.');
    }

    public function edit($id)
    {
        $ingredient = Ingredients::findOrFail($id);

        return view('admin.ingredients.edit_ingredient', compact('ingredient'));
    }

    public function ingredients()
    {
        $pizza = Ingredients::all();

        return view('admin.ingredients.ingredients', compact('pizza'));
    }


    public function create()
{
    return view('admin.ingredients.create_ingredient');
}
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        Ingredients::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.ingredients')->with('success', 'Ingrediencia pridaná');

    }

    public function destroy($id)
    {
        Ingredients::destroy($id);
        return redirect()->route('admin.ingredients')->with('success', 'Ingrediencia pridaná');

    }
    public function toggleActive($id)
    {
    $ingredients = Ingredients::findOrFail($id);
    $ingredients->is_active = !$ingredients->is_active;
    $ingredients->save();

    return redirect()->back()->with('success', 'Stav produktu bol zmenený.');
    }



}
