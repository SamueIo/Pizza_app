


@include('partials/head')

 @include('partials.header')

<div class="flex w-full h-screen">
   @include('admin/partials/side_menu')



<div class="p-5">
    <table class="min-w-full table-auto border-collapse w-full">
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
            <th class="p-2.5 border border-[#ddd]">Čas dokončenia</th>
            <th class="p-2.5 border border-[#ddd]">Zákazník</th>
            <th class="p-2.5 border border-[#ddd]">Status</th>
            <th class="p-2.5 border border-[#ddd]">Potvrdiť</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($orders as $order)
        @php
            $cart = json_decode($order->cart_data, true);
            if (is_string($cart)) {
                $cart = json_decode($cart, true);
            }
        @endphp

        @if (is_array($cart))
            @foreach ($cart as $item)
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
                        <button onclick="openModal({{ $order->id }})" class="text-blue-400 underline hover:text-blue-300">
                            Info
                        </button>
                    </td>
                    <td class="p-2.5 border border-[#3c3c3c] {{ $order['status'] === 'confirmed' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $order['status'] }}
                    </td>
                    <td class="p-2.5 border border-[#3c3c3c]">
                        <form action="{{ route('history_orders.history_delete', $order->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg"
                                    onclick="return confirm('Ste si istý, že chcete vymazať položku z histórie?')">
                                Zmazať položku
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr><td colspan="13" class="text-red-600 text-center">Neplatné dáta pre položky v objednávke ID {{ $order->id }}.</td></tr>
        @endif
    @endforeach
</tbody>


</table>
</div>
<div id="customerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white text-black rounded-lg p-6 w-full max-w-md shadow-xl relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
        <h2 class="text-2xl font-bold mb-4">Zákaznícke údaje</h2>

        <div id="modalContent">
            <!-- Tu sa dynamicky vloží obsah cez JS -->
        </div>
    </div>
</div>

</div>

<script>
    const orders = @json($orders);

    function openModal(orderId) {
        const order = orders.find(o => o.id === orderId);
        if (!order) return;

        let content = `
            <p><strong>Meno:</strong> ${order.name}</p>
            <p><strong>Email:</strong> ${order.email}</p>
            <p><strong>Telefón:</strong> ${order.phone}</p>
            <p><strong>Adresa:</strong> ${order.address}</p>
            ${order.note ? `<p><strong>Poznámka:</strong> ${order.note}</p>` : ''}
            <p class="mt-2 text-green-600"><strong>Celková cena:</strong> ${order.total_price} Kč</p>
        `;

        document.getElementById('modalContent').innerHTML = content;
        document.getElementById('customerModal').classList.remove('hidden');
        document.getElementById('customerModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('customerModal').classList.remove('flex');
        document.getElementById('customerModal').classList.add('hidden');
    }
</script>

