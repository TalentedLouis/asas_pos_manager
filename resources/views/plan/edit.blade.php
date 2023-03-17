<x-base-layout>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('plan.update', ['plan'=>$plan->id]) }}"
                  method="post">
                @csrf
                @method('put')
                <div class="flex flex-wrap">
                    <div class="px-3 mb-6 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="name" class="w-full" value="利用プラン名" />
                        <x-input id="name" class="w-full" type="text" name="name" :value="old('name', $plan->name)" required />
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="px-3 mb-6 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="use_minutes" class="w-full" value="利用時間(分)" />
                        <x-input id="use_minutes" class="w-full" type="number" name="use_minutes" :value="old('use_minutes', $plan->use_minutes)" />
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="px-3 mb-6 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="use_start_hour" class="w-full" value="利用開始時間" />
                        <x-input id="use_start_hour" class="w-full" type="number" name="use_start_hour" :value="old('use_start_hour', $plan->use_start_hour)" />
                    </div>
                    <div class="px-3 mb-6 w-full sm:w-1/2 lg:w-1/3">
                        <x-label for="use_limit_hour" class="w-full" value="利用終了時間" />
                        <x-input id="use_limit_hour" class="w-full" type="number" name="use_limit_hour" :value="old('use_limit_hour', $plan->use_limit_hour)" />
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <a class="mr-3 inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                       href="{{ route('plan.index') }}">戻る</a>
                    <x-button type="submit" class="px-6 py-3 bg-blue-500">更新する</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
