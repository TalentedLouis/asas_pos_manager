<x-base-layout>
    <x-slot name="title">棚卸一覧</x-slot>
    <x-slot name="slot">
        <table class="table-auto w-full mb-2">
            <thead>
            <tr class="border">
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-2/12 sm:w-2/12 lg:w-2/12 text-left">商品ID</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-2/12 sm:w-2/12 lg:w-2/12 text-left">商品コード</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-3/12 sm:w-3/12 lg:w-3/12 text-left">商品名</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right">平均原価</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right">現在庫</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right">棚卸数</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right">棚卸フラグ</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stocks as $stock)
                <tr class="border bg-white odd:bg-gray-100">
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-2/12 sm:w-2/12 lg:w-2/12 text-left">{{ $stock->id }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-2/12 sm:w-2/12 lg:w-2/12 text-left">{{ $stock->code }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-3/12 sm:w-3/12 lg:w-3/12 text-left">{{ $stock->name }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right">{{ $stock->avg_stocking_price }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right">{{ $stock->stocktaking_quantity }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right">
                        <input type="hidden" name="product_id" class="id" value={{ $stock->id }}>
                        <input type="number" name="stock_quantity" class="price" min="0" value={{ isset($my_input) ? $my_input : $stock->this_stock_quantity }} style="max-width: 120px">
                    </td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right child">{{ $stock->is_stocktaking ? '棚卸済' : '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $stocks->links() }}
    </x-slot>
</x-base-layout>
<script type="text/javascript">
    var elements = document.getElementsByClassName('price');

    for (var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('keypress', function() {
            if (event.key === 'Enter') {
                $.ajax({
                type: 'POST',
                url: '/stock_taking/stocks',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'id': this.parentElement.querySelector('.id').value,
                    'stock_quantity': this.value
                },
                success: function(response) {
                    console.log("reso="+response);
                    // Your logic goes here to handle the response
                },
                error: function(response) {
                    console.log('An error occurred!');
                }
                });
                // Get the parent element
                var parent = this.parentElement.parentElement;
                // Get the specific child element
                var child = parent.querySelector('.child');
                // Set the text of the child element
                if (this.value > 0) child.textContent = "棚卸済";
            }
        });
    }
</script>
