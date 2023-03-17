<x-base-layout>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('config_tax.store') }}"
                  method="post">
                @csrf
                <div class="flex flex-wrap">
                    <div class="px-3 mb-6 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="tax_rate1" class="w-full" value="標準税率" />
                        <x-input id="tax_rate1" class="w-full" type="number" step="0.01" name="tax_rate1" :value="old('tax_rate1')" required autofocus />
                    </div>
                    <div class="px-3 mb-6 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="tax_rate2" class="w-full" value="軽減税率" />
                        <x-input id="tax_rate2" class="w-full" type="number" step="0.01" name="tax_rate2" :value="old('tax_rate2')" required />
                    </div>
                    <div class="px-3 mb-6 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="started_on" class="w-full" value="適用開始日" />
                        <x-input id="started_on" class="w-full" type="date" name="started_on" :value="old('started_on')" required />
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <a class="mr-3 inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                       href="{{ route('config_tax.index') }}">戻る</a>
                    <x-button type="submit" class="px-6 py-3 bg-blue-500">追加する</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
