<x-base-layout>
    <x-slot name="title">部屋登録</x-slot>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors"/>
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('room.store') }}"
                  method="post">
                @csrf
                <div class="flex flex-wrap">
                    <div class="px-2 mb-4 w-1/4 sm:w-1/4 lg:w-1/4">
                        <x-label for="name" class="w-full" value="部屋名"/>
                        <x-input id="name" class="w-full" type="text" name="name" :value="old('name')" required autofocus/>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="px-2 mb-4 w-1/4 sm:w-1/4 lg:w-1/4">
                        <x-label for="type_id" value="部屋タイプ"/>
                        <x-select id="type_id" name="type_id" :items=$types :selected="old('type_id')" required/>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="px-2 mb-4 w-1/6 sm:w-1/6 lg:w-1/6">
                        <x-label value="喫煙 / 禁煙" />
                        <x-radio name="smoking_type_id" id="smoking_type_id_1" value="{{ \App\Enums\SmokingType::NO_SMOKING }}">禁煙</x-radio>
                        <x-radio name="smoking_type_id" id="smoking_type_id_2" value="{{ \App\Enums\SmokingType::SMOKING }}">喫煙</x-radio>
                    </div>
                    <div class="px-2 mb-4 w-1/6 sm:w-1/6 lg:w-1/6">
                        <x-label value="パソコン有無" />
                        <x-radio name="pc_type_id" id="pc_type_id_1" value="{{ \App\Enums\PcType::PC }}">あり</x-radio>
                        <x-radio name="pc_type_id" id="pc_type_id_2" value="{{ \App\Enums\PcType::NO_PC }}">なし</x-radio>
                    </div>
                </div>
                <div class="flex px-2 mb-4 items-start justify-start">
                    <a id="F1" class="mr-3 inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                       href="{{ route('room.index') }}">戻る(F1F1)</a>
                    <x-button id="F9" type="submit" class="px-6 py-3 bg-blue-500">追加する(F9)</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
