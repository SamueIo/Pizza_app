<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Extra;

class ExtraController extends Controller
{
     public function update(Request $request, $id)
    {
    $Extra = Extra::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ]);

    $Extra->name = $request->name;
    $Extra->price = $request->price;

    $Extra->save();

    return redirect()->route('admin.extras')->with('success', 'Extra príloha bola upravený.');
    }

    public function edit($id)
    {
        $extra = Extra::findOrFail($id);

        return view('admin.extras.edit_extra', compact('extra'));
    }

    public function extras()
    {
        $pizza = Extra::all();

        return view('admin/extras/extras', compact('pizza'));
    }


    public function create()
{
    return view('admin.extras.create_extras');
}
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        Extra::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.extras')->with('success', 'Extra ingrediencia pridaná');

    }

    public function destroy($id)
    {
        Extra::destroy($id);
        return redirect()->route('admin.extras')->with('success', 'Extra ingrediencia pridaná');

    }
    public function toggleActive($id)
    {
    $extra = Extra::findOrFail($id);
    $extra->is_active = !$extra->is_active;
    $extra->save();

    return redirect()->back()->with('success', 'Stav produktu bol zmenený.');
    }


}
