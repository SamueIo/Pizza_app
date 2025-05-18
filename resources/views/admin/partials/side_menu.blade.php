<!-- SIDEBAR -->
<div id="adminSidebar"
    class="fixed top-[65px] left-0 h-[calc(100%-65px)] w-[250px] min-w-[250px] bg-[rgb(71,71,71)] p-4  overflow-y-auto
           lg:translate-x-0 lg:relative lg:top-0 lg:h-full">
     <nav>
        <ul class="flex flex-col gap-2">
            <li><a href="{{ route('admin.show_orders') }}" class="block py-3 text-white text-center border border-black hover:bg-[rgb(90,90,90)]">Nové objednávky</a></li>
            <li><a href="{{ route('admin.history_orders') }}" class="block py-3 text-white text-center border border-black hover:bg-[rgb(90,90,90)]">História objednávok</a></li>
            <li><a href="{{ route('admin.show_pizzas') }}" class="block py-3 text-white text-center border border-black hover:bg-[rgb(90,90,90)]">Produkty</a></li>
            <li><a href="{{ route('admin.create_pizza') }}" class="block py-3 text-white text-center border border-black hover:bg-[rgb(90,90,90)]">Pridať produkt</a></li>
            <li><a href="{{ route('admin.breads') }}" class="block py-3 text-white text-center border border-black hover:bg-[rgb(90,90,90)]">Pečivo</a></li>
            <li><a href="{{ route('admin.ingredients') }}" class="block py-3 text-white text-center border border-black hover:bg-[rgb(90,90,90)]">Ingrediencie</a></li>
            <li><a href="{{ route('admin.extras') }}" class="block py-3 text-white text-center border border-black hover:bg-[rgb(90,90,90)]">Extra</a></li>
            <li><a href="{{ route('admin.registration') }}" class="block py-3 text-white text-center border border-black hover:bg-[rgb(90,90,90)]">Nový použivateľ</a></li>
        </ul>
    </nav>
</div>

<script>
    document.getElementById("burgerToggle").addEventListener("click", function () {
        const sidebar = document.getElementById("adminSidebar");
        sidebar.classList.toggle("-translate-x-full");
    });
</script>
