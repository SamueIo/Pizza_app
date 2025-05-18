@include('partials.head')
@include('partials.header')



<div class="flex justify-center items-center">
    <p class="text-2xl sm:text-3xl text-white font-bold underline underline-offset-8 pt-6 mb-10 text-center drop-shadow-md">
        🛒 Váš košík.
    </p>
</div>

<div class="max-w-full px-4 md:px-8 flex flex-col gap-6">
    @if (session('success'))
        <div class="flex justify-center px-4">
            <div class="bg-green-600 bg-opacity-80 text-white text-center font-semibold py-3 px-6 rounded-lg shadow-lg max-w-xl w-full">
                ✅ {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="flex justify-center px-4">
            <div class="bg-red-600 bg-opacity-80 text-white text-center font-semibold py-3 px-6 rounded-lg shadow-lg max-w-xl w-full">
                ❌ {{ session('error') }}
            </div>
        </div>
    @endif

    @if (is_array($cart) && count($cart) > 0)
        @foreach ($cart as $item)
            <div class="flex flex-col md:flex-row w-full border border-gray-300 rounded-lg p-4 shadow-md gap-6 items-start bg-black bg-opacity-30">

                {{-- Obrázok --}}
                <div class="w-full md:w-[200px] h-[200px] overflow-hidden flex-shrink-0 rounded">
                    <img src="/storage/images/{{ $item['image'] ?? 'no-image.jpg' }}" alt="Pizza image" class="object-cover w-full h-full rounded">
                </div>

                {{-- Informácie --}}
                <div class="flex flex-col justify-between flex-grow text-white w-full gap-4">
                    <div class="flex flex-col gap-1">
                        <h1 class="text-lg md:text-xl font-semibold">{{ $item['name'] ?? 'Neznáme' }}</h1>
                        <p class="text-gray-400">{{ $item['price'] ?? 0 }} kč</p>
                        <p class="text-gray-400">{{ $item['crust'] ?? 'Normálne' }} cesto</p>
                        <p class="text-gray-400">
                            {{ !empty($item['ingredients']) ? implode(', ', array_column($item['ingredients'], 'name')) : 'Žiadne ingrediencie' }}
                        </p>
                        <p class="text-gray-400">
                            {{ !empty($item['extras']) ? implode(', ', array_column($item['extras'], 'name')) : 'Žiadne extra prísady' }}
                        </p>
                    </div>

                    {{-- Spodná časť --}}
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
                        <p class="text-lg font-bold text-green-400">{{ $item['total_price'] }} kč</p>

                        <div class="flex flex-col sm:flex-row items-center sm:items-center justify-center gap-4 w-full sm:w-auto text-center">
                            {{-- Množstvo --}}
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label for="quantity" class="text-gray-300 text-sm">Množstvo:</label>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 text-center rounded bg-gray-800 text-white border border-gray-600">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">
                                    Aktualizovať
                                </button>
                            </form>

                            {{-- Zmazanie --}}
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="w-full sm:w-auto text-center">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">
                                    Zmazať
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach

        {{-- Celková cena a pokračovanie --}}
        <div class="text-center my-6 text-white">
            <p class="text-2xl font-semibold mb-4">Celková cena: {{ $priceToPay }}kč</p>
            <button
                onclick="toggleForm(event)"
                class="bg-blue-500 hover:bg-blue-600 text-white text-xl px-6 py-3 rounded-lg transition duration-300"
            >
                Pokračovať v objednávke
            </button>
        </div>

        <!-- Vysúvací formulár -->
        <div id="orderForm" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
            <div class="bg-white rounded-xl shadow-lg max-w-lg w-full mx-auto p-6 text-gray-800">
                <h1 class="text-2xl sm:text-3xl font-bold text-center mb-8">Platba v hotovosti</h1>

                <form action="/submit_order" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block font-semibold mb-1">Meno:</label>
                        <input type="text" id="name" name="name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label for="email" class="block font-semibold mb-1">Email:</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label for="phone" class="block font-semibold mb-1">Telefón:</label>
                        <input type="tel" id="phone" name="phone" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label for="address" class="block font-semibold mb-1">Adresa:</label>
                        <textarea id="address" name="address" required rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md resize-y focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>

                    <div>
                        <label for="note" class="block font-semibold mb-1">Poznámka:</label>
                        <textarea id="note" name="note" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md resize-y focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>

                    <div class="text-center pt-4 items-center">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-md transition font-semibold">
                            Odoslať objednávku
                        </button>
                    </div>
                </form>
            </div>
        </div>

    @else
        <div class="flex justify-center align-center">
            <p class="text-2xl sm:text-3xl text-white font-bold underline underline-offset-8 pt-6 mb-10 text-center drop-shadow-md">
                Zdá sa, že váš košík je prázdny.
            </p>
        </div>

    @endif
</div>


@include('partials.footer')


<script>
    function toggleForm(event) {
        event.preventDefault();
        const form = document.getElementById('orderForm');

        if (form.classList.contains('max-h-0')) {
            form.classList.remove('max-h-0');
            form.classList.add('max-h-[1000px]');
        } else {
            form.classList.remove('max-h-[1000px]');
            form.classList.add('max-h-0');
        }
    }
</script>

