<x-base-layout>
    <x-slot name="title">レシート更新</x-slot>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('receipt_config.update', ['receipt_config'=>$receipt_config->id]) }}"
                  method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="flex flex-wrap">
                    <div class="px-2 mb-4 w-full">
                        <x-label for="name" class="w-full" value="店名" />
                        <x-input id="name" class="w-full" type="text" name="name" :value="old('name', $receipt_config->name)" required autofocus />
                    </div>
                    <div class="px-2 mb-4 w-full">
                        <x-label for="address" class="w-full" value="住所" />
                        <x-input id="address" class="w-full" type="text" name="address" :value="old('address', $receipt_config->address)" required />
                    </div>
                    <div class="px-2 mb-4 w-full">
                        <x-label for="telephone" class="w-full" value="電話番号" />
                        <x-input id="telephone" class="w-full" type="text" name="telephone" :value="old('telephone', $receipt_config->telephone)" required />
                    </div>
                    <div class="px-2 mb-4 w-full">
                        <x-label for="text_1" class="w-full" value="フリーテキスト１" />
                        <x-input id="text_1" class="w-full" type="text" name="text_1" :value="old('text_1', $receipt_config->text_1)" />
                    </div>
                    <div class="px-2 mb-4 w-full">
                        <x-label for="text_2" class="w-full" value="フリーテキスト２" />
                        <x-input id="text_2" class="w-full" type="text" name="text_2" :value="old('text_2', $receipt_config->text_2)" />
                    </div>
                    <div class="px-2 mb-4 w-full">
                        <x-label for="text_3" class="w-full" value="フリーテキスト３" />
                        <x-input id="text_3" class="w-full" type="text" name="text_3" :value="old('text_3', $receipt_config->text_3)" />
                    </div>
                    <div class="px-2 mb-4 w-full">
                        <x-label for="text_4" class="w-full" value="フリーテキスト４" />
                        <x-input id="text_4" class="w-full" type="text" name="text_4" :value="old('text_4', $receipt_config->text_4)" />
                    </div>
                    <div class="px-2 mb-4 w-full">
                        <x-label for="text_5" class="w-full" value="フリーテキスト５" />
                        <x-input id="text_5" class="w-full" type="text" name="text_5" :value="old('text_5', $receipt_config->text_5)" />
                    </div>
                    <div class="px-2 mb-4 w-full">
                        <x-label for="header_image_file" class="w-full" value="ヘッダー画像" />
                        <div class="custom-file">
                            <x-input id="header_image_file" class="w-full" type="file" name="header_image_file" />
                        </div>
                        <small class="text-muted">モノクロ2階調またはグレースケール16階調で幅80mmまでの画像としてください</small>
                    </div>
                    
                    @if($receipt_config->header_image)
                        <div class="form-group row">
                            <div class="col-lg-3"></div>
                            <div id="header_image_view" class="col-lg-5">
                                <img src="{{ config('filesystems.disks')['s3']['url'] }}{{ $receipt_config->header_image }}"
                                    alt="{{ $receipt_config->header_image }}"
                                    class="img-thumbnail" />
                                <a href="#" onclick="return remove_header_image();">削除</a>
                            </div>
                            <x-input id="header_image" class="w-full" type="hidden" name="header_image" :value="old('header_image', $receipt_config->header_image)"/>
                        </div>
                    @endif

                    <div class="px-2 mb-4 w-full">
                        <x-label for="footer_image_file" class="w-full" value="フッター画像" />
                        <div class="custom-file">
                            <x-input id="footer_image_file" class="w-full" type="file" name="footer_image_file" />
                        </div>
                        <small class="text-muted">モノクロ2階調またはグレースケール16階調で幅80mmまでの画像としてください</small>
                    </div>
                    
                    @if($receipt_config->footer_image)
                        <div class="form-group row">
                            <div class="col-lg-3"></div>
                            <div id="footer_image_view" class="col-lg-5">
                                <img src="{{ config('filesystems.disks')['s3']['url'] }}{{ $receipt_config->footer_image }}"
                                    alt="{{ $receipt_config->footer_image }}"
                                    class="img-thumbnail" />
                                <a href="#" onclick="return remove_footer_image();">削除</a>
                            </div>
                            <x-input id="footer_image" class="w-full" type="hidden" name="footer_image" :value="old('footer_image', $receipt_config->footer_image)"/>
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-center">
                    <x-button type="submit" class="px-6 py-3 bg-blue-500">更新する</x-button>
                </div>
            </form>
        </div>
        <script type="text/javascript">
            function remove_footer_image() {
                $("#footer_image").val("");
                let view = $("#footer_image_view");
                $("#footer_image_view").empty();
                $("#footer_image_view").append('<span class="small text-danger">イメージの削除を保存するには「更新する」をクリックしてください</span>')
                return false;
            }
            function remove_header_image() {
                $("#header_image").val("");
                let view = $("#header_image_view");
                $("#header_image_view").empty();
                $("#header_image_view").append('<span class="small text-danger">イメージの削除を保存するには「更新する」をクリックしてください</span>')
                return false;
            }
        </script>
    </x-slot>
</x-base-layout>