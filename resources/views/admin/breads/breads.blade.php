
@include('partials/head')

 @include('partials.header')

<div class="flex w-full h-screen">
   @include('admin/partials/side_menu')



<div class="p-5 ">
    <table class="w-full border-collapse text-left">
        <thead>
            <tr class="bg-[#595959]">
                <th class="p-2.5 border border-[#ddd]">Id</th>
                <th class="p-2.5 border border-[#ddd]">Názov</th>
                <th class="p-2.5 border border-[#ddd]">Cena</th>
                <th class="p-2.5 border border-[#ddd]">Upraviť</th>
                <th class="p-2.5 border border-[#ddd]">Vymazať</th>
                <th class="p-2.5 border border-[#ddd]">Aktivita</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pizza as $item)
                <tr>
                    <td class="p-2.5 border border-[#3c3c3c]">{{ $item->id }}</td>
                    <td class="p-2.5 border border-[#3c3c3c]">{{ $item->name }}</td>
                    <td class="p-2.5 border border-[#3c3c3c]">{{ $item->price }}</td>
                    <td class="p-2.5 border border-[#ddd]">
                        <a href="{{ route('breads.edit', ['id' => $item->id]) }}">
                            <button class="px-3 py-1.5 bg-[#4CAF50] text-white border-none cursor-pointer">Upraviť</button>
                        </a>
                    </td>
                    <td class="p-2.5 border border-[#ddd]">
                        <form action="{{ route('breads.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Naozaj chceš vymazať túto položku?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-[#f44336] text-white border-none cursor-pointer">Zmazať</button>
                        </form>
                    </td>
                    <td class="p-2.5 border border-[#ddd]">
                        @if ($item->is_active)
                        <form action="{{ route('breads.toggle', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 bg-[#f44336] text-white border-none cursor-pointer">Deaktivovať</button>
                        </form>
                    @else
                        <form action="{{ route('breads.toggle', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 bg-[#4CAF50] text-white border-none cursor-pointer">Aktivovať</button>
                        </form>
                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('breads.create') }}">
        <button type="submit" class="px-3 py-1.5 pt-2 bg-[#f44336] text-white border-none cursor-pointer">Pridať novu ingredienciu</button>
    </a>



</div>




</div>





