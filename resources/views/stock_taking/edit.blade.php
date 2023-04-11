<x-base-layout>
    <x-slot name="title">棚卸登録</x-slot>
    <x-slot name="slot">
        <div class="w-full">
            <form id="form2"
                  class="w-full mb-3"
                  action="{{ route('stock_taking.code_search')}}"
                  method="post">
                @csrf
                <div class="flex flex-wrap border-b-2">
                    <div class="px-1 mb-1 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="keyword" value="商品コードで検索する" />
                        <x-input id="keyword" type="number" name="keyword" class="w-2/3" 
                                onKeydown="if (event.keyCode == 13) F5_Click()"
                                :value="old('keyword')" required autofocus />
                        <x-button id="F5" type="submit" class="px-6 py-3 bg-blue-500">検索(F5)</x-button>
                    </div>
                </div>
            </form>
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('stock_taking.update', $product -> id) }}"
                  method="post">
                @csrf
                @method('put')
                <div class="flex flex-wrap">
                    <div class="w-full">
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3 lg:w-1/3">
                            <x-label for="id" value="商品ID" />
                            <x-input id="id" type="number" name="id" class="w-full bg-gray-100" :value="old('id', $product->id)" disabled required />
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3 lg:w-1/3">
                            <x-label for="code" value="商品コード" />
                            <x-input id="code" type="number" name="code" class="w-full bg-gray-100" :value="old('code', $product->code)" disabled required />
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3 lg:w-1/3">
                            <x-label for="name" value="商品名" />
                            <x-input id="name" type="text" name="name" class="w-full bg-gray-100" :value="old('name', $product->name)" disabled required />
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="flex flex-wrap px-1 mb-1 w-full sm:w-1/3">
                            <x-label for="category_id" value="カテゴリー" />
                            <x-select id="category_id" name="category_id" class="w-full bg-gray-100" :items=$categories :selected="old('category_id', $product->category_id)" disabled required />
                        </div>
                    </div>

                    <div class="w-full">
                        <div class="flex flex-wrap px-1 mb-1 w-full sm:w-1/3">
                            <x-label for="rack_code" value="棚コード" />
                            <x-input id="rack_code" type="number" name="rack_code" step="1" class="w-full" :value="old('rack_code', @$stock->rack_code)"/>
                        </div>
                    </div>

                    <div class="w-full">
                        <div class="flex flex-wrap px-1 mb-1 w-full sm:w-1/3">
                            <x-label for="stocktaking_quantity" value="棚卸数" />
                            <x-input id="stocktaking_quantity" type="number" name="stocktaking_quantity" step="1" class="w-full" :value="old('stocktaking_quantity', @$stock->stocktaking_quantity)" required />
                        </div>
                    </div>

                    <div class="w-full">
                        <div class="flex flex-wrap px-1 mb-1 w-full sm:w-1/3">
                            <x-label for="is_stocktaking" value="棚卸済" />
                            <x-input id="is_stocktaking" type="number" name="is_stocktaking" step="1" class="w-full bg-gray-100" :value="old('is_stocktaking', @$stock->is_stocktaking)" disabled required />
                        </div>
                    </div>

                    <div class="w-full">
                        <div class="flex flex-wrap px-1 mb-1 w-full sm:w-1/3">
                            <x-label for="this_stock_quantity" value="在庫数" />
                            <x-input id="this_stock_quantity" type="number" name="this_stock_quantity" step="1" class="w-full bg-gray-100" :value="old('this_stock_quantity', @$stock->this_stock_quantity)" disabled required />
                        </div>
                    </div>

                    <div class="w-full">
                        <div class="flex flex-wrap px-1 mb-1 w-full sm:w-1/3">
                            <x-label for="avg_stocking_price" value="平均原価" />
                            <x-input id="avg_stocking_price" type="number" name="avg_stocking_price" step="1" class="w-full bg-gray-100" :value="old('avg_stocking_price', @$stock->avg_stocking_price)" disabled required />
                        </div>
                    </div>
                <div class="flex py-2 px-2 items-start justify-start">
                    <a id="F1" class="mr-3 inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                       href="{{ route('stock_taking.index') }}">戻る(F1)</a>
                    <x-button id="F9" type="submit" class="px-6 py-3 bg-blue-500">更新する(F9)</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
<script type="text/javascript">
    function F5_Click(){
        document.getElementById("F5").click();
    }
</script>
