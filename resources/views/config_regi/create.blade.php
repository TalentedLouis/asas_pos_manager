<x-base-layout>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('config_regi.store') }}"
                  method="post">
                @csrf
                <div class="flex flex-wrap">
                    <div class="px-3 mb-6 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="product_code_suffix" class="w-full" value="商品コード 先頭2桁" />
                        <x-input id="product_code_suffix" class="w-full" type="text" name="product_code_suffix" :value="old('product_code_suffix')" required autofocus />
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <x-button type="submit" class="px-6 py-3 bg-blue-500">追加する</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
