<head>
    @vite(['resources/css/app.css'])
    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');

            menu.classList.toggle('max-h-0');
            menu.classList.toggle('max-h-screen');
            menu.classList.toggle('opacity-0');
            menu.classList.toggle('opacity-100');
            menu.classList.toggle('scale-y-0');
            menu.classList.toggle('scale-y-100');
        }
    </script>
</head>

<header class="fixed top-0 left-0 w-full bg-blue-900 shadow-md z-50 h-[65px]">
    <div class="flex items-center justify-between h-[65px]  px-4 py-3 md:py-4 max-w-7xl mx-auto">

        {{-- Burger pre admina (viditeľný len pri role "admin") --}}
        @if (Auth::check() && Auth::user()->role === 'admin')
            @if (Request::is('admin*'))
                <button id="burgerToggle" class="lg:hidden text-white text-2xl mr-3">
                    ☰
                </button>
            @endif
        @endif

        {{-- Logo --}}
        <div class="text-white text-lg font-bold whitespace-nowrap">
            <a href="{{ url('/') }}">Vaše logo</a>
        </div>

        {{-- Tlačidlo mobilného menu (pre všetkých) --}}
        <button class="text-white text-2xl md:hidden ml-auto" onclick="toggleMenu()">
            ☰
        </button>

        {{-- Desktop navigácia --}}
        <nav class="hidden md:flex space-x-4 items-center ml-6">
            <a href="{{ url('/contact') }}" class="text-white">Kontakt</a>


            <a href="{{ url('/cart/index') }}" class="text-white relative">Košík
            @php
                $cart_info = session()->get('cart',[]);
                $item_count = array_sum(array_column($cart_info, 'quantity'));
            @endphp

            @if ($item_count>0)
                 <span class="absolute   -translate-x-1/5 mt-1 text-red-600 text-xm font-bold rounded-full px-2 py-0.5">
                    {{ $item_count }}
                </span>
            @endif
            </a>



            @if (Auth::check())
                @if (Auth::user()->role === 'admin')
                    <a href="{{ url('/admin/show_orders') }}" class="text-white">Admin panel</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-white">Odhlásiť sa</button>
                </form>
            @else
                <a href="{{ url('/log_in') }}" class="text-white">Správca</a>
            @endif
        </nav>
    </div>

    {{-- Mobilné menu --}}
    <div id="mobile-menu"
        class="md:hidden overflow-hidden max-h-0 opacity-0 scale-y-0 transition-all duration-300 ease-in-out origin-top bg-blue-800 rounded-lg">
        <ul class="flex flex-col space-y-2 p-4">
            <li><a href="{{ url('/contact') }}" class="text-white">Kontakt</a></li>
            <li><a href="{{ url('/cart/index') }}" class="text-white">Košík</a></li>

            @if (Auth::check())
                @if (Auth::user()->role === 'admin')
                    <li><a href="{{ url('/admin/show_orders') }}" class="text-white">Admin panel</a></li>
                @endif
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-white">Odhlásiť sa</button>
                    </form>
                </li>
            @else
                <li><a href="{{ url('/log_in') }}" class="text-white">Správca</a></li>
            @endif
        </ul>
    </div>
</header>


