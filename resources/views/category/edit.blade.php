<x-base-layout>
    <x-slot name="title">カテゴリー更新</x-slot>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('category.update', ['category'=>$category->id]) }}"
                  method="post">
                @csrf
                @method('put')
                <div class="flex flex-col">
                    <div class="px-2 mb-4 w-1/4 sm:w-1/4 lg:w-1/4">
                        <x-label for="code" class="w-full" value="カテゴリーコード" />
                        <x-input id="code" class="w-full" type="text" name="code" :value="old('code', $category->code)" required />
                    </div>
                    <div class="px-2 mb-4 w-1/2 sm:w-1/2 lg:w-1/2">
                        <x-label for="name" class="w-full" value="カテゴリー名" />
                        <x-input id="name" class="w-full" type="text" name="name" :value="old('name', $category->name)" required />
                    </div>
                    <div class="px-2 mb-4 w-1/4 sm:w-1/4 lg:w-1/4">
                        <x-label for="point_rate" class="w-full" value="ポイント率 (%)" />
                        <x-input id="point_rate" class="w-full" type="number" step="0.01" name="point_rate" :value="old('point_rate', $category->point_rate)" required />
                    </div>
                </div>
                <div class="flex px-2 mb-4 items-start justify-start">
                    <a id="F1" class="mr-3 inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                       href="{{ route('category.index') }}">戻る(F1)</a>
                    <x-button id="F9" type="submit" class="px-6 py-3 bg-blue-500">更新する(F9)</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
