<x-base-layout>
    <x-slot name="title">帳票出力　　　　　処理日付：{{ $trans_date }}</x-slot>
    <x-slot name="slot">
        <form id="form2"
                class="w-full mb-3"
                {{-- action="{{ route('product.name_search') }}" --}}
                action="{{ route('report.search') }}"
                method="post">
            @csrf
            <div class="flex flex-nowrap border-b-2 w-full sm:w-full lg:w-full">
                <div class="px-1 mb-1 w-2/12 sm:w-2/12 lg:w-2/12">
                    <x-select id="report_type_id" name="report_type_id" class="w-1/12" :items=$reportTypes :selected="old('report_type_id',$reportTypeId)" autofocus required />
                </div>
                <div class="px-1 mb-1 w-2/12 sm:w-2/12 lg:w-2/12">
                    <x-button id="F5" type="submit" class="px-6 py-3 bg-blue-500">作成(F5)</x-button>
                    <a id="F12" class="mr-3 inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                href="{{ route('report.index') }}">クリア(F12)</a>
                </div>
               <div class="px-1 mb-1 flex items-center">
                    <span class="mr-5">カテゴリー指定</span>
                    <input class="mr-1" type="radio" id="all" name="filter-type" checked onclick="handleClick(this);" value="all">全て</input>
                    <input class="mr-1 ml-5" type="radio" id="sub" name="filter-type" onclick="handleClick(this);" value="sub">個別指定</input>
                </div>
                <div class="px-1 mb-1 flex">
                    <img class="w-16 h-16 cursor-pointer" id="download-excel" src="/img/download_excel.png" alt="download_excel icon" />
                    <img class="w-14 h-14 cursor-pointer" id="download-pdf" src="/img/download_pdf.png" alt="download_pdf icon" />
                </div>
            </div>
            <div class="flex flex-nowrap border-b-2 w-full sm:w-full lg:w-full">
                <div class="px-1 mb-1 w-3/12 sm:w-3/12 lg:w-3/12">	
                    <x-input id="from_date" class="inline-flex" type="date" name="from_date" :value="old('from_date', $from_date)"></x-input> 〜
                    <x-input id="to_date" class="inline-flex" type="date" name="to_date" :value="old('to_date', $to_date)"></x-input>
                </div>
                <div class="px-1 mb-1 w-3/12 sm:w-3/12 lg:w-3/12">	
                    <x-select id="shop_id" class="inline-flex" name="shop_id" :items=$shops :selected="old('shop_id')" required />
                </div>
            </div>
        </form>
        
        @switch($reportTypeId)
        @case(1)
            @break
        @case(2)
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
            @break
        @case(3)
            @break
        @case(4)
            @break
        @case(5)
            @break
        @case(6)
            @break
        @default
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
        @endswitch

        @include('report.report-modal', ['data' => $data_for_excel])

    </x-slot>
</x-base-layout>
<script type="text/javascript">
    var checkedStatus = [];
    var categoryFilterType = false; // All: false, Sub: true;

    function F5_Click(){
        document.getElementById("F5").click();
    }

    function handleClick(item) {
        if(item.value == 'sub') {
            $('#reportModal').removeClass('invisible');
            categoryFilterType = true;
        } else {
            categoryFilterType = false;
        }
    }

    function getValue(element, category_id){
        const value = element.checked;
        if(value){
            if (!checkedStatus.includes(category_id)) checkedStatus.push(category_id);
        } else {
            const index = checkedStatus.indexOf(category_id);
            if (index !== -1)
                checkedStatus.splice(index, 1);
        }
    }

    $('#download-excel').on('click', function() {
        var from_date = "<?php echo $from_date; ?>";
        var to_date = "<?php echo $to_date; ?>";
        var shop_id = $('#shop_id').val();

        window.location.href = "/report/download_excel?from_date=" + from_date
                                                     + '&to_date=' + to_date
                                                     + '&shop_id=' + shop_id
                                                     + '&category_filter_type=' + categoryFilterType
                                                     + '&checked_status=' + checkedStatus.toString()
                                                     ;
    });

    $('#download-pdf').on('click', function() {
        var from_date = "<?php echo $from_date; ?>";
        var to_date = "<?php echo $to_date; ?>";
        var shop_id = $('#shop_id').val();

        window.location.href = "/report/download_pdf?from_date=" + from_date
                                                     + '&to_date=' + to_date
                                                     + '&shop_id=' + shop_id;
    });

    function clearAll(){
        var checkboxes = document.querySelectorAll('#sub-checkbox');
            [].forEach.call(checkboxes, (checkbox) => {
                checkbox.checked = false;
        });

        categoryFilterType = true

    }
    
    function selectAll(){
        var checkboxes = document.querySelectorAll('#sub-checkbox');
            [].forEach.call(checkboxes, (checkbox) => {
                checkbox.checked = true;
        });

        categoryFilterType = false;
    }
</script>
