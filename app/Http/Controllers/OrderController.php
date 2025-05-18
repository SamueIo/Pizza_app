<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\returnArgument;

use App\Mail\pizzaApp;
use Illuminate\Support\Facades\Mail;

use App\Models\Pizza;
use App\Models\Extra;
use App\Models\Ingredients;
use App\Models\Bread;
use App\Models\Order;
use App\Models\OrderHistory;

class OrderController extends Controller
{
    public function showForm()
    {
        return view('order');
    }
    public function submitForm(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'pizza'=> 'required',
            'address'=> 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // validácia pre obrázok
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // uloženie do adresára public/images
        }

        Pizza::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,  // uloženie cesty k obrázku
        ]);

        return redirect()->route('admin/create_pizza')->with('success', 'Pizza bola pridaná!');

    }

    public function pizza_tb()
    {
        $pizza = Pizza::all();
        $pizzaGrouped = $pizza->whereNotNull('size')
        ->sortBy(function($item) {
            return (int) filter_var($item->size, FILTER_SANITIZE_NUMBER_INT); // Odstránime jednotky
        })
        ->groupBy(function($item) {
            return (int) filter_var($item->size, FILTER_SANITIZE_NUMBER_INT); // Zoskupenie podľa čistej číselnej hodnoty
        });
        return view('welcome',compact('pizzaGrouped'));
    }

    public function pizza_info($id)
    {
    $pizza = Pizza::findOrFail($id);
    $ingredients = Ingredients::where('is_active', true)->get();
    $extra = Extra::where('is_active', true )->get();
    $bread = Bread::where('is_active', true)->get();
    return view('pizza_info', compact('pizza', 'ingredients', 'extra', 'bread'));
    }

    public function show()
    {
    $orders = Order::orderBy('created_at', 'desc')->get();
    return view('admin/orders/show_orders', compact('orders'));
    }
    public function show_history()
    {
        $orders = OrderHistory::orderBy('created_at', 'desc')->get();
        return view('admin/orders/history_orders', compact('orders'));
    }

    public function submit_order(Request $request)
{
    // Validácia údajov z formulára
    $validated = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'phone'   => 'required|string|max:20',
        'address' => 'required|string',
        'note'    => 'nullable|string',
    ]);

    $cart = session('cart', []);

    if (empty($cart)) {
        return back()->with('error', 'Košík je prázdny');
    }

    $totalPrice = collect($cart)->sum('total_price');

    $order = Order::create([
        'user_id'     => auth()->id(), // alebo null pre neprihlásených
        'name'        => $validated['name'],
        'email'       => $validated['email'],
        'phone'       => $validated['phone'],
        'address'     => $validated['address'],
        'note'        => $validated['note'] ?? '',
        'cart_data'   => json_encode($cart), // Ukladáme košík ako JSON
        'total_price' => $totalPrice,
    ]);

    $cartData = json_decode($order->cart_data, true);
    Mail::to($order->email)->send(new pizzaApp($order, $cartData));



    session()->forget('cart');

    return redirect()->back()->with('success', 'Objednávka bola úspešne odoslaná!');
    }

    public function confirm_order(Request $request, Order $order)
    {
    // Validácia prípadných dát zo žiadosti
    $request->validate([
        'order_id'     => 'required|exists:orders,id',
        'user_id'      => 'nullable|exists:users,id',
        'name'          => 'required|string',
        'email'         => 'required|email',
        'phone'         => 'nullable|string',
        'address'       => 'required|string',
        'note'          => 'nullable|string',
        'cart_data'     => 'required|json',
        'total_price'   => 'required|numeric',
        'status'        => 'required|string',
    ]);
    $cartData = json_decode($request->cart_data, true);

    OrderHistory::create([
        'order_id'      => $request->order_id,
        'user_id'       => $request->user_id,
        'name'          => $request->name,
        'email'         => $request->email,
        'phone'         => $request->phone,
        'address'       => $request->address,
        'note'          => $request->note,
        'cart_data'     => json_encode($cartData),
        'total_price'   => $request->total_price,
        'status'        => $request->status,
    ]);
    $order = Order::findOrFail($order->id);
    $order->status = $request->status;
    $order->save();



    return redirect()->back()->with('success', 'Objednávka bola potvrdená a presunutá do histórie.');


    }

    public function history_delete($id)
    {
        $order = OrderHistory::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Úspešne zmazané');
    }
    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Úspešne zmazané');
    }

    public function getOrdersData()
    {
    $orders = Order::latest()->get();
    return view('admin.orders.orders-table', compact('orders'));
    }


}
