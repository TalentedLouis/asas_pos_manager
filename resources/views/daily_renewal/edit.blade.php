<x-base-layout>
    <x-slot name="title">日次更新</x-slot>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors"></x-auth-validation-errors>
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('daily_renewal.update', ['daily_renewal'=>$shop_config->id]) }}"
                    method="post">
                @csrf
                @method('put')
                <div class="flex flex-wrap">
                    <div class="px-2 mb-4 w-1/12 sm:w-1/12 lg:w-1/12">
                        <x-label for="trans_date" class="w-full" value="処理日付"></x-label>
                        <x-input id="trans_date" class="w-full bg-gray-100" type="date" name="trans_date" :value="old('trans_date', $shop_config->trans_date)" readonly required></x-input>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="px-2 mb-4 w-1/12 sm:w-1/12 lg:w-1/12">
                        <x-label for="renewal_date" class="w-full bg-yellow-100" value="更新後の日付"></x-label>
                        <x-input id="renewal_date" class="w-full bg-yellow-100" type="date" name="renewal_date" :value="old('renewal_date', $renewal_date)" readonly required></x-input>
                    </div>
                </div>
                
                <div class="flex px-2 mb-4 items-start justify-start">
                    <x-button id="F9" type="submit" class="px-6 py-3 bg-blue-500">日次更新する(F9)</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
