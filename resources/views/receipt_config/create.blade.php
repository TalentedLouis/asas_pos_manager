<x-base-layout>
    <x-slot name="title">レシート登録</x-slot>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('receipt_config.store') }}"
                  method="post" enctype=“multipart/form-data”>
                @csrf
                <div class="flex flex-wrap">
                    <div class="px-3 mb-6 w-full">
                        <x-label for="name" class="w-full" value="店名" />
                        <x-input id="name" class="w-full" type="text" name="name" :value="old('name')" required autofocus />
                    </div>
                    <div class="px-3 mb-6 w-full">
                        <x-label for="address" class="w-full" value="住所" />
                        <x-input id="address" class="w-full" type="text" name="address" :value="old('address')" required />
                    </div>
                    <div class="px-3 mb-6 w-full">
                        <x-label for="telephone" class="w-full" value="電話番号" />
                        <x-input id="telephone" class="w-full" type="text" name="telephone" :value="old('telephone')" required />
                    </div>
                    <div class="px-3 mb-6 w-full">
                        <x-label for="text_1" class="w-full" value="フリーテキスト１" />
                        <x-input id="text_1" class="w-full" type="text" name="text_1" :value="old('text_1')" />
                    </div>
                    <div class="px-3 mb-6 w-full">
                        <x-label for="text_2" class="w-full" value="フリーテキスト２" />
                        <x-input id="text_2" class="w-full" type="text" name="text_2" :value="old('text_2')" />
                    </div>
                    <div class="px-3 mb-6 w-full">
                        <x-label for="text_3" class="w-full" value="フリーテキスト３" />
                        <x-input id="text_3" class="w-full" type="text" name="text_3" :value="old('text_3')" />
                    </div>
                    <div class="px-3 mb-6 w-full">
                        <x-label for="text_4" class="w-full" value="フリーテキスト４" />
                        <x-input id="text_4" class="w-full" type="text" name="text_4" :value="old('text_4')" />
                    </div>
                    <div class="px-3 mb-6 w-full">
                        <x-label for="text_5" class="w-full" value="フリーテキスト５" />
                        <x-input id="text_5" class="w-full" type="text" name="text_5" :value="old('text_5')" />
                    </div>
                    <div class="px-3 mb-6 w-full">
                        <x-label for="header_image_file" class="w-full" value="ヘッダー画像" />
                        <div class="custom-file">
                            <x-input id="header_image_file" class="w-full" type="file" name="header_image_file" />
                        </div>
                        <small class="text-muted">モノクロ2階調またはグレースケール16階調で幅80mmまでの画像としてください</small>
                    </div>
                    <div class="px-3 mb-6 w-full">
                        <x-label for="footer_image_file" class="w-full" value="フッター画像" />
                        <div class="custom-file">
                            <x-input id="footer_image_file" class="w-full" type="file" name="footer_image_file" />
                        </div>
                        <small class="text-muted">モノクロ2階調またはグレースケール16階調で幅80mmまでの画像としてください</small>
                    </div>

                </div>
                <div class="flex items-center justify-center">
                    <x-button type="submit" class="px-6 py-3 bg-blue-500">追加する</x-button>
                </div>
            </form>
        </div>
    </x-slot>
</x-base-layout>
