


@include('partials/head')

 @include('partials.header')

<div class="flex w-full h-screen">
    <!-- Navigácia naľavo -->
    @include('admin/partials/side_menu')
    <div class="flex justify-center w-full">

            <!-- Formulár a náhľad obrázka vedľa seba -->
        <div class="flex w-[85%] gap-5 p-5 pr-20">
        <!-- Formulár -->
        <div class="w-full px-7">
            <form method="POST" action="{{ route('pizzas.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block">Názov pizze</label>
                    <input type="text" name="name" class="w-full p-2.5 border border-[#ddd] rounded" required>
                </div>

                <div>
                    <label class="block">Velkosť pizze</label>
                    <input type="number" name="size" class="w-full p-2.5 border border-[#ddd] rounded" required>
                </div>

                <div>
                    <label class="block">Popis</label>
                    <textarea name="description" class="w-full p-2.5 border border-[#ddd] rounded"></textarea>
                </div>

                <div>
                    <label class="block">Cena (€)</label>
                    <input type="number" step="0.01" name="price" class="w-full p-2.5 border border-[#ddd] rounded" required>
                </div>

                <div>
                    <label class="block">Fotka</label>
                    <input type="file" name="image" class="w-full p-2.5 border border-[#ddd] rounded">
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Pridať pizzu</button>
            </form>
        </div>

        <!-- Náhľad obrázka -->
        <div id="live-preview" class="flex flex-col w-[350px] h-[450px] border border-gray-300 rounded-lg p-4 shadow-md gap-4">
            <div class="w-full h-[225px] overflow-hidden bg-gray-100 flex items-center justify-center">
                <img id="preview-image" src="" alt="Pizza image" class="object-cover w-full h-full hidden">
                <span id="image-placeholder" class="text-gray-400">Náhľad obrázka</span>
            </div>

            <div class="flex flex-col items-center justify-center text-center gap-4">
                <h1 id="preview-name" class="text-xl font-semibold text-gray-500">Názov pizze</h1>
                <p id="preview-description" class="text-gray-400 line-clamp-3">Popis sa zobrazí tu...</p>
            </div>

            <div class="flex flex-row justify-between items-center mt-auto">
                <p id="preview-price" class="text-lg font-bold text-green-500">0.00 €</p>
                <button disabled class="bg-blue-500 text-white px-4 py-2 rounded-lg opacity-50 cursor-not-allowed">
                  Detaily
                </button>
            </div>
        </div>
        </div>
    </div>

</div>







<script>
    // Názov pizze
    document.querySelector('input[name="name"]').addEventListener('input', function () {
        document.getElementById('preview-name').textContent = this.value || 'Názov pizze';
    });

    // Popis
    document.querySelector('textarea[name="description"]').addEventListener('input', function () {
        document.getElementById('preview-description').textContent = this.value || 'Popis sa zobrazí tu...';
    });

    // Cena
    document.querySelector('input[name="price"]').addEventListener('input', function () {
        document.getElementById('preview-price').textContent = this.value ? `${this.value} €` : '0.00 €';
    });

    // Obrázok
    document.querySelector('input[name="image"]').addEventListener('change', function () {
        const file = this.files[0];
        const previewImg = document.getElementById('preview-image');
        const placeholder = document.getElementById('image-placeholder');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            previewImg.src = '';
            previewImg.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    });
</script>



