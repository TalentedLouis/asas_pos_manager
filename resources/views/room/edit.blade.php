<x-base-layout>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors"/>
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('room.update', ['room'=>$room->id]) }}"
                  method="post">
                @csrf
                @method('put')
                <div class="flex flex-wrap">
                    <div class="px-3 mb-6 w-full lg:w-2/3">
                        <x-label for="name" class="w-full" value="部屋名"/>
                        <x-input id="name" class="w-full" type="text" name="name" :value="old('name', $room->name)"
                                 required/>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="px-3 mb-6 w-full lg:w-2/3">
                        <x-label for="type_id" value="部屋タイプ"/>
                        <x-select id="type_id" name="type_id" :items=$types :selected="old('type_id', $room->type_id)"
                                  required/>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="px-3 mb-6 w-1/2 lg:w-1/3">
                        <x-label value="喫煙 / 禁煙"/>
                        <x-radio name="smoking_type_id" id="smoking_type_id_1" value="{{ \App\Enums\SmokingType::NO_SMOKING }}"
                                 input="{{ old('smoking_type_id', $room->smoking_type_id) }}">禁煙</x-radio>
                        <x-radio name="smoking_type_id" id="smoking_type_id_2" value="{{ \App\Enums\SmokingType::SMOKING }}"
                                 input="{{ old('smoking_type_id', $room->smoking_type_id) }}">喫煙</x-radio>
                    </div>
                    <div class="px-3 mb-6 w-1/2 lg:w-1/3">
                        <x-label value="パソコン有無"/>
                        <x-radio name="pc_type_id" id="pc_type_id_1" value="{{ \App\Enums\PcType::PC }}"
                                 input="{{ old('pc_type_id', $room->pc_type_id) }}">あり</x-radio>
                        <x-radio name="pc_type_id" id="pc_type_id_2" value="{{ \App\Enums\PcType::NO_PC }}"
                                 input="{{ old('pc_type_id', $room->pc_type_id) }}">なし</x-radio>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <a class="mr-3 inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                       href="{{ route('room.index') }}">戻る</a>
                    <x-button type="submit" class="px-6 py-3 bg-blue-500">更新する</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
