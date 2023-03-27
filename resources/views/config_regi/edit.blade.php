<x-base-layout>
    <x-slot name="title">レジ情報更新</x-slot>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('config_regi.update', ['config_regi'=>$config_regi->id]) }}"
                  method="post">
                @csrf
                @method('put')
                <div class="flex flex-wrap">
                    <div class="px-2 mb-4 w-1/4 sm:w-1/4 lg:w-1/4">
                        <x-label for="product_code_suffix" class="w-full" value="商品コード 先頭2桁" />
                        <x-input id="product_code_suffix" class="w-full" type="text" name="product_code_suffix" :value="old('product_code_suffix', $config_regi->product_code_suffix)" required autofocus />
                    </div>
                </div>
                <div class="flex px-2 mb-4 items-start justify-start">
                    <x-button id="F9" type="submit" class="px-6 py-3 bg-blue-500">更新する(F9)</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
