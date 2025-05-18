@include('partials/head')


    @include('partials.header')

    <div class="flex flex-col w-full  p-4 md:p-10">
    <!-- Success message -->
    <div>
        @if (session('success'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <!-- Content container -->
    <div class="flex flex-col md:flex-row gap-4 w-full ]">

        <!-- Pizza Image -->
        <div class="w-full h-[250px] sm:h-[300px] md:w-[350px] md:h-[350px] lg:w-[500px] lg:h-[500px] overflow-hidden flex-shrink-0 rounded-lg">
    <img src="/storage/images/{{ $pizza->image }}" alt="Pizza image" class="object-cover w-full h-full rounded-lg">
    </div>


        <!-- Pizza Info -->
        <div class="flex flex-col w-full text-white px-5 gap-4">
            <div class="flex justify-between">
                <h1 class="text-2xl font-semibold ">{{ $pizza->name }}</h1>
                <h1 class="text-2xl font-semibold">{{ $pizza->size ? $pizza->size . ' cm' : '' }}</h1>
            </div>
            <p class="text-gray-400 line-clamp-3">{{ $pizza->description }}</p>

            <!-- Pizza Form -->
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf

                <!-- Crust Selection -->
                <div class="mb-4 w-full">
                    <input type="hidden" name="pizza_id" value="{{ $pizza->id }}">
                    <label for="crust" class="block text-lg font-semibold">Vyber druh cesta:</label>
                    <div class="flex items-center justify-between mt-2">
                        <select name="crust" id="crust" class="w-full p-2 border rounded-lg bg-gray-800 text-white">
                            @foreach ($bread as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->price }} Kč</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Ingredients Selection -->
                <div class="mb-4">
                    <label class="block text-lg font-semibold">Vyber ingrediencie:</label>
                    @foreach ($ingredients as $ingredient)
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="ingredient_{{ $ingredient->id }}" name="ingredients[]" value="{{ $ingredient->id }}" class="mr-2 form-checkbox text-blue-500 w-5 h-5 rounded-md border-gray-400">
                                <label for="ingredient_{{ $ingredient->id }}" class="text-sm">{{ $ingredient->name }}</label>
                            </div>
                            <p class="text-sm">+{{ $ingredient->price }} kč</p>
                        </div>
                    @endforeach
                </div>

                <!-- Extra Add-ons -->
                <div class="mb-4">
                    <label class="block text-lg font-semibold">Prídavné hodnoty:</label>
                    @foreach ($extra as $item)
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="extra_{{ $item->id }}" name="extras[]" value="{{ $item->id }}" class="mr-2 form-checkbox text-blue-500 w-5 h-5 rounded-md border-gray-400">
                                <label for="extra_{{ $item->id }}" class="text-sm">{{ $item->name }}</label>
                            </div>
                            <p class="text-sm">+{{ $item->price }} kč</p>
                        </div>
                    @endforeach
                </div>

                <!-- Submit Button -->
                <div class="flex flex-row justify-between items-center mt-auto mb-4">
                    <p class="text-lg font-bold text-green-500">{{ $pizza->price }} kč</p>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">Objednať</button>
                </div>
            </form>
        </div>
    </div>
</div>












@include('partials/footer')
