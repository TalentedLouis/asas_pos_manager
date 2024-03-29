<x-base-layout>
    <x-slot name="title">自店情報更新</x-slot>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors"></x-auth-validation-errors>
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('shop_config.update', ['shop_config'=>$shop_config->id]) }}"
                  method="post">
                @csrf
                @method('put')
                <div class="flex flex-wrap">
                    <div class="px-2 mb-4 w-1/4 sm:w-1/4 lg:w-1/4">
                        <x-label for="trans_date" class="w-full" value="処理日付"></x-label>
                        <x-input id="trans_date" class="w-full" type="date" name="trans_date" :value="old('trans_date', $shop_config->trans_date)" required></x-input>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="px-2 mb-4 w-1/4 sm:w-1/4 lg:w-1/4">
                        <x-label for="delay_minutes" class="w-full" value="延長時間(分)"></x-label>
                        <x-input id="delay_minutes" class="w-full" type="text" name="delay_minutes" :value="old('delay_minutes', $shop_config->delay_minutes)" required></x-input>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="px-2 mb-4 w-1/4 sm:w-1/4 lg:w-1/4">
                        <x-label for="exit_reserve_minutes" class="w-full" value="退室予備時間(分)"></x-label>
                        <x-input id="exit_reserve_minutes" class="w-full" type="text" name="exit_reserve_minutes" :value="old('exit_reserve_minutes', $shop_config->exit_reserve_minutes)" required></x-input>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="px-2 mb-4 w-1/4 sm:w-1/4 lg:w-1/4">
                        <x-label for="slip_number_sequence" class="w-full" value="伝票番号 連番"></x-label>
                        <x-input id="slip_number_sequence" class="w-full" type="text" name="slip_number_sequence" :value="old('slip_number_sequence', $shop_config->slip_number_sequence)" required></x-input>
                    </div>
                </div>
                <div class="flex px-2 mb-4 items-start justify-start">
                    <x-button id="F9" type="submit" class="px-6 py-3 bg-blue-500">更新する(F9)</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
