<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use Illuminate\Http\Request;

use App\Models\Extra;

use App\Models\Bread;

use App\Models\Pizza;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart',compact('cart'));
    }

    public function addToCart(Request $request)
{
    $pizzaDtbs = Pizza::findOrFail($request->pizza_id);

    $extraIds = $request->input('extras', []);
    $extraDtbs = Extra::whereIn('id', $extraIds)->get();

    $ingredientsIds = $request->input('ingredients',[]);
    $ingredientsDtbs = Ingredients::whereIn('id', $ingredientsIds)->get();

    $breadDtbs = Bread::findOrFail($request->crust);
    $pizza = [
        'id' => $request->pizza_id,
        'name' => $pizzaDtbs->name,
        'price' => $pizzaDtbs->price,
        'image' => $pizzaDtbs->image,
        'crust' => $breadDtbs->name,
        'ingredients' => $ingredientsDtbs->map(function($ingredients){
            return [
                'id' =>$ingredients->id,
                'name' =>$ingredients->name,
                'price' =>$ingredients->price,
            ];
        })->toArray(),
        'extras' => $extraDtbs->map(function ($extra) {
            return [
                'id' => $extra->id,
                'name' => $extra->name,
                'price' => $extra->price,
            ];
        })->toArray(),
    ];

    $total_price = $pizza['price'];

    if (!empty($pizza['extras'])) {
        foreach ($pizza['extras'] as $extra) {
            $total_price += $extra['price'];
        }
    }
    if (!empty($pizza['ingredients'])) {
        foreach ($pizza['ingredients'] as $ingredients) {
            $total_price += $ingredients['price'];
        }
    }

    if (!empty($breadDtbs->price)) {
    $total_price += $breadDtbs->price;
    }

    $pizza['total_price'] = $total_price;
    $pizza['original_price'] = $total_price;

    $cart = session()->get('cart', []);

    $found = false;
    foreach ($cart as $key => $item) {
        if (
            $item['id'] == $pizza['id'] &&
            $item['crust'] == $pizza['crust'] &&
            $item['ingredients'] == $pizza['ingredients']
        ) {
            $cart[$key]['quantity']++;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $pizza['quantity'] = 1;
        $cart[] = $pizza;
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Položka bola pridaná do košíka. Cena: ' . $total_price . ' Kč');
}



    public function showCart()
    {
        $cart = session()->get('cart', []);
        $priceToPay = 0;

        foreach ($cart as $item) {
            $priceToPay += $item['total_price'];
        }

        // dd($cart);
        return view('cart.index', compact('cart', 'priceToPay'));
    }

    public function remove($id)
{
    $cart = session()->get('cart', []);

    foreach ($cart as $key => $item) {
        if ($item['id'] == $id) {
            unset($cart[$key]);
            break;
        }
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Položka bola úspešne odstránená z košíka.');
    }

    public function update(Request $request, $id)
    {
    $cart = session()->get('cart', []);

    foreach ($cart as $key => $item) {
        if ($item['id'] == $id) {
            $cart[$key]['quantity'] = $request->quantity;

            $cart[$key]['total_price'] = $cart[$key]['quantity'] * $cart[$key]['original_price'];

            break;
        }
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Množstvo bolo aktualizované.');
}



}
