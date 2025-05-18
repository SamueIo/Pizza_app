@include('partials.head')
@include('partials.header')



<style>
    .glow-underline {
        position: relative;
        overflow: hidden;
    }

    .glow-underline input {
        position: relative;
        z-index: 1;
        background: transparent;
    }

    .glow-underline::after {
        content: "";
        position: absolute;
        left: -100%;
        bottom: 0;
        width: 50%; /* Ak chceš, aby to bolo len na polovicu */
        height: 2px;
        background: linear-gradient(to right, #3b82f6, #60a5fa, #3b82f6);
        animation: glowing-border 2s linear infinite;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.8), 0 0 15px rgba(59, 130, 246, 0.6);
        transition: opacity 1s ease-out, box-shadow 1s ease-out;
    }


    .glow-underline.no-animation::after {
        opacity: 0;
        box-shadow: none;
    }

    @keyframes glowing-border {
        0% {
            left: -100%;
        }
        100% {
            left: 100%;
        }
    }
</style>


<div class="flex w-full h-screen relative">

    <!-- Navigácia naľavo -->
    @include('admin/partials/side_menu')

    @if (session('success'))
        <!-- Flexbox na zarovnanie správy do stredu hore -->
        <div class="absolute top-3 left-1/2 transform -translate-x-1/2">
            <div class="bg-green-500 text-white p-4 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Formulár zarovnaný na stred -->
    <div class="flex flex-1 justify-center items-center">
        <form method="POST" action="{{ route('admin.register') }}" class="w-full max-w-md space-y-4 p-6 text-white rounded-lg">
            @csrf

            <h1 class="text-2xl font-bold text-center mb-4">Registrácia</h1>

            <!-- Meno -->
            <div>
                <label for="name" class="block mb-1 text-sm font-medium">Meno</label>
                <input type="text" id="name" name="name" class="w-full p-2.5 border border-[#ddd] rounded text-white focus:outline-none focus:ring focus:ring-blue-500" placeholder="Zadajte meno" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block mb-1 text-sm font-medium">Email</label>
                <input type="email" id="email" name="email" class="w-full p-2.5 border border-[#ddd] rounded text-white focus:outline-none focus:ring focus:ring-blue-500" placeholder="Zadajte email" required>
            </div>

            <!-- Heslo -->
            <div>
                <label for="password" class="block mb-1 text-sm font-medium">Heslo</label>
                <!-- Zmeňte type na text -->
                <input type="text" id="password" name="password" class="w-full p-2.5 border border-[#ddd] rounded text-white focus:outline-none focus:ring focus:ring-blue-500" placeholder="Zadajte heslo" required>
            </div>

            <!-- Nastavenie role -->
            <div>
                <label for="role" class="block mb-1 text-sm font-medium">Nastavte rolu</label>
                <input type="text" id="role" name="role" class="w-full p-2.5 border border-[#ddd] rounded text-white focus:outline-none focus:ring focus:ring-blue-500" placeholder="Zadajte rolu" required>
            </div>

            <!-- Tlačidlo -->
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Vytvoriť používateľa
            </button>

</form>


    </div>
</div>

</div>

