<x-base-layout>
    <x-slot name="slot">
        <div class="w-full mb-3">
            <div class="flex flex-wrap">
                <a class="mr-3 inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                   href="{{ route('config_tax.create') }}">消費税率を追加する</a>
            </div>
        </div>
        <table class="table-auto w-full mb-2">
            <thead>
            <tr class="border">
                <th class="py-2 px-1 sm:px-2 lg:px-4">標準税率</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4">軽減税率</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4">適用開始日</th>
                <th class="py-2 px-1 sm:px-2 lg:px-4 w-1/4 sm:w-1/5 lg:w-1/6">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($configTaxes as $configTax)
                <tr class="border bg-white odd:bg-gray-100">
                    <td class="py-2 px-1 sm:px-2 lg:px-4">{{ $configTax->tax_rate1 }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4">{{ $configTax->tax_rate2 }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4">{{ $configTax->started_on }}</td>
                    <td class="py-2 px-1 sm:px-2 lg:px-4 text-right">
                        <a class="mr-0.5 sm:mr-1 lg:mr-2" href="{{ route('config_tax.edit', ['config_tax'=>$configTax->id]) }}">
                            <x-far-edit class="inline-block w-6 h-6 text-blue-600"/></a>
                        <form action="{{ route('config_tax.destroy', ['config_tax'=>$configTax->id]) }}"
                              class="inline-block"
                              method="post">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('config_tax.destroy', ['config_tax'=>$configTax->id]) }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                <x-far-trash-alt class="inline-block w-6 h-6 text-red-600"/></a>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $configTaxes->links() }}
    </x-slot>
</x-base-layout>