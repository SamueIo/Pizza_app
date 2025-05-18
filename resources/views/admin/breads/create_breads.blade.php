

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@include('partials/head')

 @include('partials.header')

<div class="flex w-full h-screen">
    <!-- Navigácia naľavo -->
    @include('admin/partials/side_menu')

    <!-- Formulár a náhľad obrázka vedľa seba -->
    <div class="flex w-full gap-5 p-5 pr-20">
        <!-- Formulár -->
        <div class="w-full px-7">
            <form method="POST" action="{{ route('breads.add') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block">Názov pečiva</label>
                    <input type="text" name="name" class="w-full p-2.5 border border-[#ddd] rounded" required>
                </div>
                <div>
                    <label class="block">Cena peciva</label>
                    <input type="text" name="price" class="w-full p-2.5 border border-[#ddd] rounded" required>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Pridať</button>
            </form>
        </div>

    </div>
</div>



