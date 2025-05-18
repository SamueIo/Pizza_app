<style>
    html {
        scroll-behavior: smooth;
    }
    .text-shadow {
        text-shadow: 2px 2px 16px rgba(0, 0, 0, 0.7);
        background-color: rgba(0, 0, 0, 0.84);
        padding:  2% ;
        border-radius: 30%;

    }
    .main-photo{
        opacity: 0.5;
    }
</style>
<div class="relative w-full ">
    <!-- Fotka pozadia -->
    <img src="/storage/background_photo/background.jpg" alt="Pozadie"
         class="w-full h-auto max-h-[500px] object-cover main-photo">

    <!-- Obsah nad obrázkom -->
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center  px-4">
        <h1 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold mt-4 text-shadow">
            Čo si dnes dáte?
        </h1>

        <!-- Odkazy na veľkosti pizz -->
        <div class="flex flex-wrap justify-center gap-4 mt-6 animate-fade-in-slow text-shadow">
            @foreach ($pizzaGrouped as $size => $group)
                <a href="#size-{{ $size }}"
                   class="text-white text-lg sm:text-xl font-semibold hover:text-blue-400 hover:underline transition duration-300">
                    {{ $size }} cm
                </a>
            @endforeach
        </div>
    </div>
</div>


<div class="max-w-full px-4 sm:px-6 md:px-8 lg:px-25">

    <!-- Zoznam pizz rozdelený podľa veľkosti -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($pizzaGrouped as $size => $group)
            <!-- Sekcia pre každú veľkosť -->
            <div id="size-{{ $size }}" class="col-span-full mb-4">
                <!-- Nadpis pre každú veľkosti s pozadím okolo textu -->
                <div class="text-base sm:text-xl md:text-xl lg:text-2xl xl:text-2xl text-center font-semibold mb-4 text-white py-2 px-4 sm:px-6 md:px-8 rounded-lg shadow-md">
                    {{ $size }} cm
                </div>




                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-4 lg:grid-cols-3 gap-6">
    @foreach ($group as $item)
        <!-- Pizza karta -->
        <div class="flex flex-col h-[450px] border border-gray-300 rounded-lg p-4 shadow-md gap-4">
            <!-- Obrazok pizze -->
            <div class="w-full overflow-hidden">
                <img src="/storage/images/{{ $item->image }}" alt="Pizza image" class="object-cover w-full h-[220px]">
            </div>

            <!-- Informácie o pizzi -->
            <div class="flex flex-col items-center justify-center text-center gap-4">
                <h1 class="text-xl font-semibold">{{ $item->name }}</h1>
                <p class="text-gray-400 line-clamp-3">{{ $item->description }}</p>
            </div>

            <!-- Cena a detaily -->
            <div class="flex flex-row justify-between items-center mt-auto">
                <p class="text-lg font-bold text-green-500">{{ $item->price }} kč</p>
                <p class="text font-semibold">{{ $item->size ? $item->size . ' cm' : '' }}</p>
                <a class="btn btn-primary bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg" href="{{ url('pizza_info/' . $item->id) }}">Detaily</a>
            </div>

        </div>
    @endforeach
</div>

            </div>
        @endforeach
    </div>
</div>
