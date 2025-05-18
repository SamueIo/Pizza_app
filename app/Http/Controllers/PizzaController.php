<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;
use App\Models\Ingredients;
use Illuminate\Support\Str;
class PizzaController extends Controller
{
    public function create_pizza()
    {

    return view('admin.pizzas.create_pizza');
    }

    // public function store(Request $request)
    // {
    //     $data = new Pizza;

    //     $data->name = $request->name;
    //     $data->size = $request->size;
    //     $data->description = $request->description;
    //     $data->price = $request->price;

    //     $image = $request->file('image');

    //     if ($image) {
    //         $imageName = time().'.'.$image->getClientOriginalExtension();

    //         $image->storeAs('public/images', $imageName);

    //         $data->image = $imageName;
    //     } else {
    //         return redirect()->back()->with('error', 'Obrázok nebol nahraný.');
    //     }

    //     $data->save();

    //     return redirect()->back()->with('success', 'Produkt bol pridaný');
    // }



    public function store(Request $request)
{
    $data = new Pizza;

    $data->name = $request->name;
    $data->size = $request->size;
    $data->description = $request->description;
    $data->price = $request->price;

    $image = $request->file('image');

    if ($image) {
        $imageName = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/storage/images';

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $image->move($destinationPath, $imageName);

        $data->image = $imageName;
    } else {
        return redirect()->back()->with('error', 'Obrázok nebol nahraný.');
    }

    $data->save();

    return redirect()->back()->with('success', 'Produkt bol pridaný');
}

    public function show_pizzas()
    {
        $pizza = Pizza::all();

        return view('admin/pizzas/show_pizzas', compact('pizza'));
    }

    public function edit($id)
    {
        $pizza = Pizza::findOrFail($id);
        return view('admin/pizzas/edit_pizza', compact('pizza'));
    }

   public function update(Request $request, $id)
{
    $pizza = Pizza::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'size' => 'required|integer|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $pizza->name = $request->name;
    $pizza->size = $request->size;
    $pizza->description = $request->description;
    $pizza->price = $request->price;

    if ($request->hasFile('image')) {

        if ($pizza->image) {
        $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . '/storage/images/' . $pizza->image;
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
    }

    $imageName = time() . '.' . $request->image->getClientOriginalExtension();

    $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/storage/images';

    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    $request->image->move($destinationPath, $imageName);

    $pizza->image = $imageName;
}


    $pizza->save();

    return redirect()->route('admin.show_pizzas')->with('success', 'Pizza bola upravená.');
}
    public function destroy($id)
    {
        $pizza = Pizza::findOrFail($id);

        $pizza->delete();

        return redirect()->route('admin.show_pizzas')->with('success', 'Pizza bola vymazaná.');
    }


    public function show_contact()
    {
    return view('contact');
    }






}
