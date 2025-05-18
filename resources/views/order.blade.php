<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Objednávka pizze</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-md mx-auto bg-white p-6  rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Objednávka pizze</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="/order" class="space-y-4">
            @csrf

            <div>
                <label class="block">Meno:</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block">Výber pizze:</label>
                <select name="pizza" class="w-full border p-2 rounded">
                    <option value="margherita">Margherita</option>
                    <option value="hawaii">Hawaii</option>
                    <option value="salami">Saláma</option>
                </select>
            </div>

            <div>
                <label class="block">Adresa:</label>
                <textarea name="address" class="w-full border p-2 rounded" required></textarea>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Objednať</button>
        </form>
    </div>

</body>
</html>
