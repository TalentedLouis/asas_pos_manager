<x-base-layout>
    <x-slot name="slot">
        <form id="form2"
                class="w-full mb-3"
                action="{{ route('product.name_search') }}"
                method="post">
            @csrf
            <div class="flex flex-wrap border-b-2 w-11/12 sm:w-11/12 lg:w-11/12">
                <div class="px-3 mb-6 w-1/12 sm:w-1/12 lg:w-1/12">
                    <x-label for="product_search_type" class="w-2/12 sm:w-2/12 lg:w-2/12" value="" />
                    <a id="F1" class="mr-3 inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            href="{{ route('product.create') }}">商品追加(F1)</a>
                </div>
                <div class="px-3 mb-6 w-11/12 sm:w-11/12 lg:w-11/12">
                    <div class="px-3 mb-6 w-full sm:w-3/3 lg:w-3/3">							
                        <x-label for="product_search_type" class="w-2/12 sm:w-2/12 lg:w-2/12" value="商品名検索" />
                        <x-input id="keyword" type="text" name="keyword" class="w-2/12 sm:w-2/12 lg:w-2/12" :value="old('keyword')" autofocus />
                        <x-button id="F9" type="submit" class="px-6 py-3 bg-blue-500">検索(F9)</x-button>
                        <a id="F12" class="mr-3 inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    href="{{ route('product.index') }}">クリア(F12)</a>
                    </div>
                </div>
            </div>
            {{--
            <div class="px-3 mb-6 w-1/12 sm:w-1/12 lg:w-1/12">
                    <x-select id="product_search_type" name="product_search_type" class="w-2/12 sm:w-2/12 lg:w-2/12" :items=$productSearchType :selected="old('product_search_type')" required />
                    <x-select id="product_search_type" name="product_search_type" class="w-full" :items=$productSearchType :selected="old('product_search_type')" required />
                    <a id="F12" class="mr-3 inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            href="{{ route('product.index') }}">クリア(F12)</a>
            </div>
            --}}
        </form>
        
        <table class="table-auto w-full mb-2">
            <thead>
            <tr class="border">
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right">商品コード</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-3/12 sm:w-3/12 lg:w-3/12 text-left">商品名</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-left">ｱｰﾃｨｽﾄ</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-1/48 text-right">▲</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-2/48 lg:w-2/48 text-left">カテゴリー</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-1/48 text-right">△</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-2/48 lg:w-2/48 text-left">ジャンル</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-1/48 text-right">売値</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-1/48 text-right">仕入値</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-1/48 text-right">在庫</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-left">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr class="border bg-white odd:bg-gray-100">
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-right">{{ $product->code }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-3/12 sm:w-3/12 lg:w-3/12 text-left">{{ $product->name }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-left">{{ $product->artist }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-1/48 text-right">{{ $product->category_id }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-2/48 text-left">{{ $product->category->name }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-1/48 text-right">{{ $product->genre_id }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-2/48 text-left">{{ $product->genre->name }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-1/48 text-right">{{ $product->sell_price }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-1/48 text-right">{{ $product->stocking_price }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/48 sm:w-1/48 lg:w-1/48 text-right">{{ $product->this_stock_quantity }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/12 sm:w-1/12 lg:w-1/12 text-left">
                        <a class="mr-0.5 sm:mr-1 lg:mr-2" href="{{ route('product.edit', ['product'=>$product->id]) }}">
                            <x-far-edit class="inline-block w-6 h-6 text-blue-600"/></a>
                        <x-delete :route="route('product.destroy', ['product'=>$product->id])">
                            <x-far-trash-alt class="inline-block w-6 h-6 text-red-600"/>
                        </x-delete>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    </x-slot>
</x-base-layout>
