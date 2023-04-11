<x-base-layout>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('config_regi.store') }}"
                  method="post">
                @csrf
                <div class="flex flex-col">
                    <div class="px-2 mb-4 w-1/4 sm:w-1/4 lg:w-1/4">
                        <x-label for="product_code_suffix" class="w-full" value="商品コード 先頭2桁" />
                        <x-input id="product_code_suffix" class="w-full" type="text" name="product_code_suffix" :value="old('product_code_suffix')" required autofocus />
                    </div>

                    <div class="px-2 mb-4 w-1/4 sm:w-1/4 lg:w-1/4">
                        <x-label for="entry_exit_money_code" class="w-full" value="入出金バーコード" />
                        <x-input id="entry_exit_money_code" class="w-full" type="text" name="entry_exit_money_code" :value="old('entry_exit_money_code')" required autofocus />
                    </div>
                </div>
                <div class="flex px-2 mb-4 items-start justify-start">
                    <x-button id="F9" type="submit" class="px-6 py-3 bg-blue-500">追加する(F9)</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
