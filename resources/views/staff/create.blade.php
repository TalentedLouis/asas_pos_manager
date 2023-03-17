<x-base-layout>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('staff.store') }}"
                  method="post">
                @csrf
                <div class="flex flex-wrap">
                    <div class="px-3 mb-6 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="name" class="w-full" value="スタッフ名" />
                        <x-input id="name" class="w-full" type="text" name="name" :value="old('name')" required autofocus />
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <a class="mr-3 inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                       href="{{ route('staff.index') }}">戻る</a>
                    <x-button type="submit" class="px-6 py-3 bg-blue-500">追加する</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
