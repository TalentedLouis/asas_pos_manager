<x-base-layout>
    <x-slot name="title">顧客登録</x-slot>
    <x-slot name="slot">
        <div class="w-full">
            <form id="form2"
                  class="w-full mb-3"
                  action="{{ route('customer.code_search') }}"
                  method="post">
                @csrf
                <div class="flex flex-wrap border-b-2">
                    <div class="px-1 mb-1 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="keyword" value="顧客コードで検索する" />
                        <x-input id="keyword" type="number" name="keyword" class="w-2/3" :value="old('keyword')" required autofocus />
                        <x-button id="F5" type="submit" class="px-6 py-3 bg-blue-500">検索(F5)</x-button>
                    </div>
                </div>
            </form>
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('customer.store') }}"
                  method="post">
                @csrf
                <div class="flex flex-wrap">
                    <div class="w-full">
                        <div class="px-1 mb-1 w-1/3 sm:w-1/2 lg:w-1/3">
                            <x-label for="code" class="w-full" value="顧客コード" />
                            <x-input id="code" class="w-full" type="text" name="code" :value="old('code')" required autofocus />
                        </div>
                    </div>
                    <div class="flex flex-wrap border-b-2 w-full">
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3">
                            <x-label for="name" class="w-full" value="顧客名" />
                            <x-input id="name" class="w-full" type="text" name="name" :value="old('name')" />
                        </div>
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3">
                            <x-label for="read" class="w-full" value="顧客名カナ" />
                            <x-input id="read" class="w-full" type="text" name="read" :value="old('read')"  />
                        </div>
                    </div>
                    
                    <div class="w-full">
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3">
                                <x-label for="sex" value="性別" />
                                <x-select id="sex" name="sex" class="w-full" :items=$sexTypes :selected="old('sex')" />
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3">
                            <x-label for="birthday" class="w-full" value="誕生日" />
                            <x-input id="birthday" class="w-full" type="date" name="birthday" :value="old('birthday')" />
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="px-1 mb-1 w-1/3 sm:w-1/3">
                            <x-label for="zip_code" class="w-full" value="郵便番号" />
                            <x-input id="zip_code" class="w-full" type="text" name="zip_code" :value="old('zip_code')" />
                        </div>
                    </div>
                    <div class="px-1 mb-1 w-1/3 sm:w-1/3">
                        <x-label for="address_1" class="w-full" value="住所１" />
                        <x-input id="address_1" class="w-full" type="text" name="address_1" :value="old('address_1',null)" />
                    </div>
                    <div class="px-1 mb-1 w-1/3 sm:w-1/3">
                        <x-label for="address_2" class="w-full" value="住所２" />
                        <x-input id="address_2" class="w-full" type="text" name="address_2" :value="old('address_2',null)" />
                    </div>
                    <div class="px-1 mb-1 w-1/3 sm:w-1/3">
                        <x-label for="address_3" class="w-full" value="住所３" />
                        <x-input id="address_3" class="w-full" type="text" name="address_3" :value="old('address_3',null)" />
                    </div>
                    
                    <div class="px-1 mb-1 w-1/3 sm:w-1/3">
                        <x-label for="tel" class="w-full" value="電話" />
                        <x-input id="tel" class="w-full" type="text" name="tel" :value="old('tel',null)" />
                    </div>
                    <div class="px-1 mb-1 w-1/3 sm:w-1/3">
                        <x-label for="portable" class="w-full" value="携帯" />
                        <x-input id="portable" class="w-full" type="text" name="portable" :value="old('portable',null)" />
                    </div>
                    <div class="px-1 mb-1 w-1/3 sm:w-1/3">
                        <x-label for="note" class="w-full" value="備考" />
                        <x-input id="note" class="w-full" type="text" name="note" :value="old('note',null)" />
                    </div>

                    <div class="flex items-center justify-center px-1 mb-1">
                        <a id="F1" class="mr-3 inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        href="{{ route('customer.index') }}">戻る(F1)</a>
                        <x-button id="F9" type="submit" class="px-6 py-3 bg-blue-500">追加する(F9)</x-button>
                    </div>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
