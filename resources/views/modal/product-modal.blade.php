<div class="fixed z-10 inset-0 invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="interestModal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center ">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
        <div class="inline-block m-auto bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all lg:w-11/12">
            <div class="bg-white px-4 pt-5 pb-4">
                <div id="slip" class="w-full mb-16">
                    <div class="flex flex-wrap border-b-2 w-12/12 sm:w-12/12 lg:w-12/12">
                        <div class="px-3 mb-6 w-2/12 sm:w-2/12 lg:w-2/12">
                            <x-label for="product_search_type" class="w-2/12 sm:w-2/12 lg:w-2/12" value="" />
                            <a id="F1" class="mr-3 inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    href="{{ route('product.create') }}">商品追加(F1)</a>
                        </div>
                        <div class="px-3 mb-6 w-9/12 sm:w-9/12 lg:w-9/12">
                            <div class="px-3 mb-6 w-full sm:w-3/3 lg:w-3/3">							
                                <x-label for="product_search_type" class="w-2/12 sm:w-2/12 lg:w-2/12" value="商品名検索" />
                                <x-input id="keyword" type="text" name="keyword" class="w-2/12 sm:w-2/12 lg:w-2/12" :value="old('keyword')" autofocus />
                                <x-button id="F9" type="button" class="px-6 py-3 bg-blue-500" onclick="getProducts();">検索(F9)</x-button>
                                <x-button id="F12" type="button" class="px-6 py-3 bg-blue-500" onclick="keyNameClear();">クリア(F12)</x-button>
                            </div>
                        </div>
                        <div class="px-3 mb-6 w-1/12 sm:w-1/12 lg:w-1/12">
                            <x-button type="button" class="px-6 py-3" style="color: black;" onclick="closeModal();">X</x-button>
                        </div>
                    </div>
                        
                    <table class="table-auto w-full mb-2">
                        <thead>
                        <tr class="border">
                            <th></th>
                            <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right">商品コード</th>
                            <th class="py-2 px-1 sm:px-2 lg:px-4 w-3/12 sm:w-3/12 lg:w-3/12 text-left">商品名</th>
                            <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-2/48 lg:w-2/48 text-left">カテゴリー</th>
                            <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-2/48 lg:w-2/48 text-left">ジャンル</th>
                        </tr>
                        </thead>
                        <tbody id="products-table">
                        @foreach($products as $product)
                            <tr class="border bg-white odd:bg-gray-100">
                                <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-center"><input type="radio" id="product" name="product_select" onclick="handleProductClick({{$product}});" value="{{$product}}" /></td>
                                <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right">{{ $product->code }}</td>
                                <td class="py-2 px-1 sm:px-2 lg:px-4 w-3/12 sm:w-3/12 lg:w-3/12 text-left">{{ $product->name }}</td>
                                <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-2/48 text-left">{{ $product->category->name }}</td>
                                <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-2/48 text-left">{{ $product->genre->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function handleProductClick(item){
        let purchase_key = localStorage.getItem('purchase_key')
        let page_type = localStorage.getItem('page_type')        

        console.log('product page type');
        console.log(item.code);

        if(page_type == 'create')       
            Livewire.emit('changeProduct', purchase_key, item.code);
        if(page_type == 'edit')
            Livewire.emit('changeProduct', 0, item.code);

        $('#interestModal').addClass('invisible');
    }
    function getProducts(){
        let keyword  = document.getElementById('keyword').value;
        $.ajax({
            type:'POST',
            url:'/product/name_search_result',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                'keyword': keyword
            },
            success:function(res) {
                let data = res.data;
                let resultTable = '';
                for(let i = 0; i < data.length; i ++){
                    resultTable += "<tr class='border bg-white odd:bg-gray-100'>";
                    resultTable += "<td class='py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-center'><input type='radio' id='product' name='product_select' onclick='handleProductClick(" + JSON.stringify(data[i]) + ");' value='" + JSON.stringify(data[i]) + "'></td>"
                    resultTable += "<td class='py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right'>" + data[i].code + "</td>"
                    resultTable += "<td class='py-2 px-1 sm:px-2 lg:px-4 w-3/12 sm:w-3/12 lg:w-3/12 text-left'>" + data[i].name + "</td>"
                    resultTable += "<td class='py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-2/48 text-left'>" + data[i].category.name + "</td>"
                    resultTable += "<td class='py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-2/48 text-left'>" + data[i].genre.name + "</td></tr>";
                }
                let table = document.getElementById('products-table');
                table.innerHTML = resultTable;
            }
        });
    }
    function keyNameClear(){
        document.getElementById('keyword').value = '';
        getProducts();
    }
    function closeModal(){
        $('#interestModal').addClass('invisible');
    }
</script>