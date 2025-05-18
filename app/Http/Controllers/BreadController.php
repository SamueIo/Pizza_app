<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bread;

class BreadController extends Controller
{
     public function update(Request $request, $id)
    {
    $bread = Bread::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ]);

    $bread->name = $request->name;
    $bread->price = $request->price;

    $bread->save();

    return redirect()->route('admin.breads')->with('success', 'Pečivo bola upravené.');
    }

    public function edit($id)
    {
        $bread = Bread::findOrFail($id);

        return view('admin/breads/edit_breads', compact('bread'));
    }

    public function breads()
    {
        $pizza = Bread::all();
        return view('admin/breads/breads', compact('pizza'));
    }


    public function create()
{
    return view('admin.breads.create_breads');
}
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        Bread::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.breads')->with('success', 'Pečivo pridané');

    }

    public function destroy($id)
    {
        Bread::destroy($id);
        return redirect()->route('admin.breads')->with('success', 'Pečivo pridané');

    }

    public function toggleActive($id)
    {
    $bread = Bread::findOrFail($id);
    $bread->is_active = !$bread->is_active;
    $bread->save();

    return redirect()->back()->with('success', 'Stav produktu bol zmenený.');
    }

}
