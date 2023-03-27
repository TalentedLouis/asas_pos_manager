<x-base-layout>
    <x-slot name="title">売上一覧</x-slot>
    <x-slot name="slot">
        <div class="w-full mb-3">
            <div class="flex flex-wrap">
                <div class="w-full sm:w-1/3 mb-2 sm:mb-0">
                    <a id="F1" class="mr-3 inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                       href="{{ route('sale.create') }}">売上を追加する(F1)</a>
                </div>
                <div class="w-full sm:w-2/3">
                    <form id="form2" action="{{ route('sale.search') }}" method="post">
                        @csrf
                        <x-label class="w-full" value="期間"></x-label>
                        <x-input id="from_date" class="inline-flex" type="date" name="from_date" :value="old('from_date', $from_date)"></x-input> 〜
                        <x-input id="to_date" class="inline-flex" type="date" name="to_date" :value="old('to_date', $to_date)"></x-input>
                        <x-button type="submit" class="px-6 py-3 bg-gray-600">検索</x-button>
                    </form>
                    @error('from_date')
                    <div class="w-full"><div class="text-red-500">{{ $message }}</div></div>
                    @enderror
                    @error('to_date')
                    <div class="w-full"><div class="text-red-500">{{ $message }}</div></div>
                    @enderror

                </div>
            </div>
        </div>
        <table class="table-auto w-full mb-2">
            <thead>
            <tr class="border">
                <th class="py-2 px-1 sm:px-2 lg:px-4 text-left">処理日付</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 text-left">伝票No.</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 text-left">顧客</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 text-left">金額</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 text-left">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($slips as $slip)
                <tr class="border bg-white odd:bg-gray-100">
                    <td class="py-2 px-1 sm:px-2 lg:px-4 text-left">{{ $slip->transacted_on }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 text-left">{{ $slip->slip_no }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 text-left">{{ $slip->customer->name }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 text-left">{{ number_format($slip->total_payment_amount) }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 text-left">
                        <a class="mr-0.5 sm:mr-1 lg:mr-2" href="{{ route('sale.edit', ['slip'=>$slip->id]) }}">
                            <x-far-edit class="inline-block w-6 h-6 text-blue-600"/></a>
                        <x-delete :route="route('sale.destroy', ['slip'=>$slip->id])">
                            <x-far-trash-alt class="inline-block w-6 h-6 text-red-600"/>
                        </x-delete>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $slips->links() }}
    </x-slot>
</x-base-layout>
