<h1>Ďakujeme za vašu objednávku!</h1>

<p>Objednávka č.: {{ $order->id }}</p>
<p>Meno: {{ $order->name }}</p>
<p>Email: {{ $order->email }}</p>
<p>Adresa: {{ $order->address }}</p>
<p>Celková suma: {{ $order->total_price }} kč</p>

<h3>Obsah košíka:</h3>
<ul>
    @foreach($cartData as $item)
        <li>
            {{ $item['name'] }} - {{ $item['crust'] ?? '' }}

            <!-- Cena pre crust -->
            @if(!empty($item['crust']))
                (Cesto: {{ $item['crust'] }} - Cena: {{ $item['crust_price'] ?? 0 }} kč)
            @endif

            <!-- Cena pre ingrediencie -->
            @if(!empty($item['ingredients']) && is_array($item['ingredients']))
                (Ingrediencie:
                    {{ collect($item['ingredients'])->pluck('name')->implode(', ') }}
                    - Cena:
                    {{ collect($item['ingredients'])->sum('price') }} kč
                )
            @endif

            <!-- Cena pre extras -->
            @if(!empty($item['extras']) && is_array($item['extras']))
                (Prílohy:
                    {{ collect($item['extras'])->pluck('name')->implode(', ') }}
                    - Cena:
                    {{ collect($item['extras'])->sum('price') }} kč
                )
            @endif

            (x{{ $item['quantity'] ?? 1 }}) - {{ $item['total_price'] }} kč

            <!-- Cena položky -->
        </li>
    @endforeach
</ul>




@if($order->note)
    <p>Poznámka: {{ $order->note }}</p>
@endif
