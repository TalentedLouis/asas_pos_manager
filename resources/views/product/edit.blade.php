<x-base-layout>
    <x-slot name="slot">
        <div class="w-full">
            <form id="form2"
                  class="w-full mb-3"
                  action="{{ route('product.code_search') }}"
                  method="post">
                @csrf
                <div class="flex flex-wrap border-b-2">
                    <div class="px-1 mb-1 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="keyword" value="商品コードで検索する" />
                        <x-input id="keyword" type="number" name="keyword" class="w-2/3" :value="old('keyword')" required autofocus />
                        <x-button id="F5" type="submit" class="px-6 py-3 bg-blue-500">検索(F5)</x-button>
                    </div>
                    <div class="px-1 mb-1 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="keyword" value="商品コードを新規作成する" />
                        <a id="F2" class="mr-3 inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                           href="{{ route('product.code_create') }}">商品コード作成(F2)</a>
                    </div>
                </div>
            </form>
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('product.update', ['product' => $product->id]) }}"
                  method="post">
                @csrf
                @method('put')
                <div class="flex flex-wrap">
                    <div class="w-full">
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3 lg:w-1/3">
                            <x-label for="code" value="商品コード" />
                            <x-input id="code" type="number" name="code" class="w-full" :value="old('code', $product->code)" required />
                        </div>
                    </div>
                    <div class="flex flex-wrap border-b-2 w-full">
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3 lg:w-1/3">
                            <x-label for="name" value="商品名" />
                            <x-input id="name" type="text" name="name" class="w-full" :value="old('name', $product->name)" required />
                        </div>
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3 lg:w-1/3">
                            <x-label for="name_read" value="商品カナ" />
                            <x-input id="name_read" type="text" name="name_read" class="w-full" :value="old('name_read', $product->name_read)"  />
                        </div>
                    </div>
                    <div class="flex flex-wrap border-b-2 w-full">
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3 lg:w-1/3">
                            <x-label for="artist" value="アーティスト" />
                            <x-input id="artist" type="text" name="artist" class="w-full" :value="old('artist', $product->artist)" />
                        </div>
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3 lg:w-1/3">
                            <x-label for="artist_read" value="アーティストカナ" />
                            <x-input id="artist_read" type="text" name="artist_read" class="w-full" :value="old('artist_read', $product->artist_read)"  />
                        </div>
                    </div>
                    <div class="px-1 mb-1 w-full sm:w-1/3">
                        <x-label for="category_id" value="カテゴリー" />
                        <x-select id="category_id" name="category_id" class="w-full" :items=$categories :selected="old('category_id', $product->category_id)" />
                    </div>
                    <div class="px-1 mb-1 w-full sm:w-1/3">
                        <x-label for="genre_id" value="ジャンル" />
                        <x-select id="genre_id" name="genre_id" class="w-full" :items=$genres :selected="old('genre_id', $product->genre_id)" />
                    </div>
                    <div class="px-1 mb-1 w-full sm:w-1/3">
                        <x-label for="maker_id" value="メーカー" />
                        <x-select id="maker_id" name="maker_id" class="w-full" :items=$makers :selected="old('maker_id', $product->maker_id)" />
                    </div>
                    <div class="px-1 mb-1 w-full sm:w-1/3">
                        <x-label for="sell_price" value="販売価格" />
                        <x-input id="sell_price" type="number" name="sell_price" step="0.01" class="w-full" :value="old('sell_price', @$stock->sell_price)" required />
                    </div>
                    <div class="px-1 mb-1 w-full sm:w-1/3">
                        <x-label for="sell_tax_rate_type_id" value="販売価格 税設定" />
                        <x-select id="sell_tax_rate_type_id" name="sell_tax_rate_type_id" class="w-full" :items=$taxRateTypes :selected="old('sell_tax_rate_type_id', @$stock->sell_tax_rate_type_id)" required />
                    </div>
                    <div class="px-1 mb-1 w-full sm:w-1/3">
                        <x-label for="sell_taxable_method_type_id" value="販売価格 適用税率" />
                        <x-select id="sell_taxable_method_type_id" name="sell_taxable_method_type_id" class="w-full" :items=$taxableMethodTypes :selected="old('sell_taxable_method_type_id', @$stock->sell_taxable_method_type_id)" required />
                        {{-- <x-select id="sell_taxable_method_type_id" name="sell_taxable_method_type_id" class="w-full" :items=$taxableMethodTypes :selected="old('sell_taxable_method_type_id', @$stock->sell_taxable_method_type_id)" /> --}}
                    </div>

                    <div class="px-1 mb-1 w-full sm:w-1/3">
                        <x-label for="stocking_price" value="仕入価格" />
                        <x-input id="stocking_price" type="number" name="stocking_price" step="0.01" class="w-full" :value="old('stocking_price', @$stock->stocking_price)" required />
                    </div>
                    <div class="px-1 mb-1 w-full sm:w-1/3">
                        <x-label for="stocking_tax_rate_type_id" value="仕入価格 税設定" />
                        <x-select id="stocking_tax_rate_type_id" name="stocking_tax_rate_type_id" class="w-full" :items=$taxRateTypes :selected="old('stocking_tax_rate_type_id', @$stock->stocking_tax_rate_type_id)" required />
                    </div>
                    <div class="px-1 mb-1 w-full sm:w-1/3">
                        <x-label for="stocking_taxable_method_type_id" value="仕入価格 適用税率" />
                        <x-select id="stocking_taxable_method_type_id" name="stocking_taxable_method_type_id" class="w-full" :items=$taxableMethodTypes :selected="old('stocking_taxable_method_type_id', @$stock->stocking_taxable_method_type_id)" required />
                    </div>
                    <div class="flex flex-wrap border-b-2 w-full">
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3 lg:w-1/3">
                            <x-label for="note1" value="備考1" />
                            <x-input id="note1" type="text" name="note1" class="w-full" :value="old('note1', $product->note1)"  />
                        </div>
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3 lg:w-1/3">
                            <x-label for="note2" value="備考2" />
                            <x-input id="note2" type="text" name="note2" class="w-full" :value="old('note2', $product->note2)"  />
                        </div>
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3 lg:w-1/3">
                            <x-label for="note3" value="備考3" />
                            <x-input id="note3" type="text" name="note3" class="w-full" :value="old('note3', $product->note3)"  />
                        </div>
                    </div>
                </div>
                <table class="table-auto w-full mb-2">
                    <thead>
                    <tr class="border">
                        <th class="py-2 px-2 text-left">店舗</th>
                        <th class="py-2 px-2 text-left">在庫数</th>
                        <th class="py-2 px-2 text-left">平均単価</th>
                        <th class="py-2 px-2 text-left">販売価格</th>
                        <th class="py-2 px-2 text-left">仕入価格</th>
                        <th class="py-2 px-2 text-left">最終販売日</th>
                        <th class="py-2 px-2 text-left">総販売数</th>
                        <th class="py-2 px-2 text-left">最終仕入日</th>
                        <th class="py-2 px-2 text-left">総仕入数</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($product->stocks as $stock)
                        <tr class="border bg-white odd:bg-gray-100">
                            <td class="py-2 px-2">{{ $stock->shop->name }}</td>
                            <td class="py-2 px-2">{{ $stock->this_stock_quantity }}</td>
                            <td class="py-2 px-2">{{ $stock->avg_stocking_price }}</td>
                            <td class="py-2 px-2">{{ $stock->sell_price }}</td>
                            <td class="py-2 px-2">{{ $stock->stocking_price }}</td>
                            <td class="py-2 px-2">{{ $stock->last_sell_on }}</td>
                            <td class="py-2 px-2">{{ $stock->total_sell_quantity }}</td>
                            <td class="py-2 px-2">{{ $stock->last_purchase_on }}</td>
                            <td class="py-2 px-2">{{ $stock->total_purchase_quantity }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="flex items-center justify-center">
                    <a id="F1" class="mr-3 inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                       href="{{ route('product.index') }}">戻る(F1)</a>
                    <x-button id="F9" type="submit" class="px-6 py-3 bg-blue-500">更新する(F9)</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
