<x-base-layout>
    <x-slot name="title">顧客一覧</x-slot>
    <x-slot name="slot">
        <div class="flex flex-wrap border-b-2 w-full sm:w-full lg:w-full">
            <div class="px-3 mb-6 w-2/16 sm:w-2/16 lg:w-2/16">
                <x-label for="product_search_type" class="w-10/12 sm:w-10/12 lg:w-10/12" value="　" />
                <a id="F1" class="mr-3 inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        href="{{ route('customer.create') }}">顧客追加(F1)</a>
            </div>
            <div class="px-3 mb-6 w-8/16 sm:w-8/16 lg:w-8/16">
                <form id="form2"
                        class="w-full mb-3"
                        action="{{ route('customer.code_search') }}"
                        method="post">
                    @csrf
                    <div class="px-1 mb-1 w-full sm:w-full lg:w-full">
                        <x-label for="keyword" value="顧客コードで検索する" />
                        <x-input id="keyword" type="number" name="keyword" class="w-4/16" 
                                onKeydown="if (event.keyCode == 13) F5_Click()"
                                :value="old('keyword')" required autofocus />
                        <x-button id="F5" type="submit" class="px-6 py-3 bg-blue-500">検索(F5)</x-button>
                    </div>
                </form>
            </div>
            <div class="px-3 mb-6 w-5/16 sm:w-5/16 lg:w-5/16">
                <form id="form2"
                        class="w-full mb-3"
                        action="{{ route('customer.name_search') }}"
                        method="post">
                    @csrf
                    <div class="flex flex-wrap border-b-2 w-full sm:w-12/12 lg:w-12/12">
                        <div class="px-3 mb-6 w-full sm:w-3/3 lg:w-3/3">							
                            <x-label for="keyword" class="w-4/12 sm:w-4/12 lg:w-4/12" value="顧客名検索" />
                            <x-input id="keyword" type="text" name="keyword" class="w-4/12 sm:w-4/12 lg:w-4/12" :value="old('keyword')" autofocus />
                            <x-button id="F9" type="submit" class="px-6 py-3 bg-blue-500">検索(F9)</x-button>
                            <a id="F12" class="mr-3 inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                        href="{{ route('customer.index') }}">クリア(F12)</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table-auto w-full mb-2">
            <thead>
            <tr class="border">
                <th class="py-2 px-1 sm:px-2 lg:px-4 W-1/16 sm:w-1/16 lg:w-1/16 text-right">顧客コード</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-2/16 sm:w-2/16 lg:w-2/16 text-right">ポイント</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-8/16 sm:w-8/16 lg:w-8/16 text-left">顧客名</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-5/16 sm:w-5/16 lg:w-5/16 text-left">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr class="border bg-white odd:bg-gray-100">
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-1/16 sm:w-1/16 lg:w-1/16 text-right">{{ $customer->code }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-2/16 sm:w-2/16 lg:w-2/16 text-right">{{ $customer->total_point }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-3/16 sm:w-3/16 lg:w-3/16 text-left">{{ $customer->name }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 w-5/16 sm:w-5/16 lg:w-5/16 text-left">
                        <a class="mr-0.5 sm:mr-1 lg:mr-2" href="{{ route('customer.edit', ['customer'=>$customer->id]) }}">
                            <x-far-edit class="inline-block w-6 h-6 text-blue-600"/></a>
                        {{--
                        <x-delete :route="route('customer.destroy', ['customer'=>$customer->id])">
                            <x-far-trash-alt class="inline-block w-6 h-6 text-red-600"/>
                        </x-delete>
                        --}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $customers->links() }}
    </x-slot>
</x-base-layout>
<script type="text/javascript">
    function F5_Click(){
        document.getElementById("F5").click();
    }
</script>
