


@include('partials/head')

 @include('partials.header')

{{-- @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif --}}

<div class="flex w-full h-screen ">

   @include('admin/partials/side_menu')

<div id="ordersTable" class="">
    @include('admin.orders.orders-table')
</div>


{{-- @include('partials/footer') --}}
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function refreshOrdersTable() {
        fetch('{{ route('orders.get_orders_data') }}')
            .then(response => response.text())
            .then(html => {
                document.getElementById('ordersTable').innerHTML = html;
            })
            .catch(error => {
                console.error('Chyba pri načítaní objednávok:', error);
            });
    }

    // Spustenie po načítaní stránky
    document.addEventListener('DOMContentLoaded', function () {
        refreshOrdersTable();
        setInterval(refreshOrdersTable, 10000); // každé 2 sekundy
    });
</script>

<script>
    function openModalFromData(button) {
        let content = `
            <p><strong>Meno:</strong> ${button.dataset.name}</p>
            <p><strong>Email:</strong> ${button.dataset.email}</p>
            <p><strong>Telefón:</strong> ${button.dataset.phone}</p>
            <p><strong>Adresa:</strong> ${button.dataset.address}</p>
            ${button.dataset.note ? `<p><strong>Poznámka:</strong> ${button.dataset.note}</p>` : ''}
            <p class="mt-2 text-green-600"><strong>Celková cena:</strong> ${button.dataset.totalPrice} Kč</p>
        `;

        document.getElementById('modalContent').innerHTML = content;
        document.getElementById('customerModal').classList.remove('hidden');
        document.getElementById('customerModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('customerModal').classList.remove('flex');
        document.getElementById('customerModal').classList.add('hidden');
    }
</script>

