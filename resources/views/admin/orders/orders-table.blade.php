

<div class="p-5 overflow-x-auto">
    <table class="min-w-full table-auto border-collapse w-full text-sm">
    <thead>
        <tr>
            <th class="p-2.5 border border-[#ddd]">Id pizze</th>
            <th class="p-2.5 border border-[#ddd]">Obrázok</th>
            <th class="p-2.5 border border-[#ddd]">Názov</th>
            <th class="p-2.5 border border-[#ddd]">Množstvo</th>
            <th class="p-2.5 border border-[#ddd]">Cesto</th>
            <th class="p-2.5 border border-[#ddd]">Ingrediencie</th>
            <th class="p-2.5 border border-[#ddd]">Extra</th>
            <th class="p-2.5 border border-[#ddd]">Cena</th>
            <th class="p-2.5 border border-[#ddd]">Poznámka</th>
            <th class="p-2.5 border border-[#ddd]">Čas objednania</th>
            <th class="p-2.5 border border-[#ddd]">Zákazník</th>
            <th class="p-2.5 border border-[#ddd]">Status</th>
            <th class="p-2.5 border border-[#ddd]">Zmazať</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($orders as $order)
            {{-- teraz môžeš používať $order->cart_data --}}
            @foreach (json_decode($order->cart_data, true) as $item)
                <tr>
                    <td class="p-2.5 border border-[#3c3c3c]">{{ $item['id'] }}</td>
                    <td class="p-2.5 border border-[#3c3c3c]">
                        <img src="{{ asset('storage/images/' . $item['image']) }}" alt="Obrázok" class="w-16 h-16 object-cover rounded">
                    </td>
                    <td class="p-2.5 border border-[#3c3c3c]">{{ $item['name'] }}</td>
                    <td class="p-2.5 border border-[#3c3c3c]">{{ $item['quantity'] }}</td>
                    <td class="p-2.5 border border-[#3c3c3c]">{{ $item['crust'] }}</td>

                    <td class="p-2.5 border border-[#3c3c3c]">
                        @if (!empty($item['ingredients']))
                            {{ implode(', ', array_column($item['ingredients'], 'name')) }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="p-2.5 border border-[#3c3c3c]">
                        @if (!empty($item['extras']))
                            {{ implode(', ', array_column($item['extras'], 'name')) }}
                        @else
                            -
                        @endif
                    </td>


                    <td class="p-2.5 border border-[#3c3c3c]">{{ $item['total_price'] }}</td>
                    <td class="p-2.5 border border-[#3c3c3c]">{{ $order['note'] }}</td>
                    <td class="p-2.5 border border-[#3c3c3c]">
                        {{ \Carbon\Carbon::parse($order['created_at'])->format('H:i | d.m') }}
                    </td>

                    <td class="p-2.5 border border-[#3c3c3c] text-center">
                        <button onclick="openModalFromData(this)"
                            class="text-blue-400 underline hover:text-blue-300"
                            data-name="{{ $order->name }}"
                            data-email="{{ $order->email }}"
                            data-phone="{{ $order->phone }}"
                            data-address="{{ $order->address }}"
                            data-note="{{ $order->note }}"
                            data-total-price="{{ $order->total_price }}">
                            Info
                        </button>

                    </td>

                    <td class="p-2.5 border border-[#3c3c3c]">
                        @if($order->status == 'confirmed')
                            <!-- Zobrazenie zelenej fajky -->
                            <span class="text-green-600 text-xl">✔️</span>
                        @else
                            <!-- Formulár na potvrdenie objednávky -->
                            <form action="{{ route('orders.confirm_order', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                                <input type="hidden" name="name" value="{{ $order->name }}">
                                <input type="hidden" name="email" value="{{ $order->email }}">
                                <input type="hidden" name="phone" value="{{ $order->phone }}">
                                <input type="hidden" name="address" value="{{ $order->address }}">
                                <input type="hidden" name="note" value="{{ $order->note }}">
                                <input type="hidden" name="cart_data" value='@json($order->cart_data)'>
                                <input type="hidden" name="total_price" value="{{ $order->total_price }}">
                                <input type="hidden" name="status" value="confirmed">

                                <button type="submit"
                                        class="btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                    Hotová objednávka
                                </button>
                            </form>
                        @endif
                    </td>


                    <td class="p-2.5 border border-[#3c3c3c]">
                        <form action="{{ route('orders.delete', $order->id) }}" method="POST" onsubmit="return confirm('Ste si istý, že chcete vymazať túto objednávku?')">
                            @csrf
                            @method('DELETE') <!-- DELETE na vymazanie objednávky -->
                            <button type="submit" class="btn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                Vymazať objednávku
                            </button>
                        </form>
                    </td>




                </tr>
            @endforeach

        @endforeach
    </tbody>
</table>
</div>
<div id="customerModal" onclick="closeModal()" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white text-black rounded-lg p-6 w-full max-w-md shadow-xl relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
        <h2 class="text-2xl font-bold mb-4">Zákaznícke údaje</h2>

        <div id="modalContent">
            <!-- Tu sa dynamicky vloží obsah cez JS -->
        </div>
    </div>
</div>
</div>

