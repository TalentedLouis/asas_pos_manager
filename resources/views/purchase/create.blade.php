<x-base-layout>
    <x-slot name="title">仕入登録　　　　　処理日付：{{ $trans_date }}</x-slot>
    <x-slot name="slot">
        <div class="w-full">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form id="form1" name="form1"
                  class="w-full"
                  action="{{ route('purchase.store') }}"
                  method="post">
                @csrf
                <div id="slip" class="w-full mb-16">
                    <livewire:transactions :transaction_type_id="$transaction_type_id" :slip="$slip" />
                    @include('modal.product-modal', ['products' => $products])
                </div>
                <div class="w-full fixed bottom-0 left-40 lg:left-48 bg-gray-300">
                    <div class="">
                        <div class="flex flex-wrap">
                            <div class="px-4 mt-2 mb-2 w-1/16 flex items-center">
                            </div> 
                            <div class="px-0 mt-2 mb-2 w-1/13 flex items-right">
                                <a id="F1" class="mr-3 inline-flex items-right px-0 py-2 bg-blue-500 text-sm border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                   href="{{ route('purchase.index') }}">　　　一覧　　　<br>　　　(F1)</a>
                            </div>
                            <div class="px-1 mt-2 mb-2 w-1/13 flex items-center">
                                <x-button  type="button" class="px-4 py-0 bg-gray-600 text-sm">　　　　　　<br>(F2)</x-button>
                            </div>
                            <div class="px-1 mt-2 mb-2 w-1/13 flex items-center">
                                <x-button  type="button" class="px-4 py-0 bg-gray-600 text-sm">　　　　　　<br>(F3)</x-button>
                            </div>
                            <div class="px-1 mt-2 mb-2 w-1/13 flex items-center">
                                <x-button id="F4" type="button" class="px-4 py-0 bg-blue-500 text-sm" onclick="addProduct()">　10行追加　<br>(F4)</x-button>
                            </div>
                            <div class="px-4 mt-2 mb-2 w-1/16 flex items-center">
                            </div>    
                            <div class="px-2 mt-2 mb-2 w-1/13 flex items-center">
                                <x-button  type="button" class="px-4 py-0 bg-gray-600 text-sm">　　　　　　<br>(F5)</x-button>
                            </div>
                            <div class="px-1 mt-2 mb-2 w-1/13 flex items-center">
                                <x-button  type="button" class="px-4 py-0 bg-gray-600 text-sm">　　　　　　<br>(F6)</x-button>
                            </div>
                            <div class="px-1 mt-2 mb-2 w-1/13 flex items-center">
                                <x-button  type="button" class="px-4 py-0 bg-gray-600 text-sm">　　　　　　<br>(F7)</x-button>
                            </div>
                            <div class="px-1 mt-2 mb-2 w-1/13 flex items-center">
                                <x-button  type="button" class="px-4 py-0 bg-gray-600 text-sm">　　　　　　<br>(F8)</x-button>
                            </div>
                            <div class="px-4 mt-2 mb-2 w-1/16 flex items-center">
                            </div>   
                            <div class="px-1 mt-2 mb-2 w-1/13 flex items-center">
                                <x-button id="F9" type="submit" class="px-4 py-0 bg-blue-500 text-sm">　　登録　　<br>(F9)</x-button>
                            </div>
                            <div class="px-1 mt-2 mb-2 w-1/13 flex items-center">
                                <x-button  type="button" class="px-4 py-0 bg-gray-600 text-sm">　　　　　　<br>(F10)</x-button>
                            </div>
                            <div class="px-1 mt-2 mb-2 w-1/13 flex items-center">
                                <x-button  type="button" class="px-4 py-0 bg-gray-600 text-sm">　　　　　　<br>(F11)</x-button>
                            </div>
                            <div class="px-1 mt-2 mb-2 w-1/13 flex items-center">
                                <x-button  type="button" class="px-4 py-0 bg-gray-600 text-sm">　　　　　　<br>(F12)</x-button>
                            </div> 
                        </div>    
                    </div>
                </div>
            </form>
        </div>
        <script type="text/javascript">
            const formElement = document.getElementById('form1');
            formElement.addEventListener('submit', (e) => {
                e.preventDefault();
                document.form1.submit();
            });

            function addProduct(){
                console.log('-- add product ---');
                Livewire.emit('transactionAdd', 10);
            }
        </script>
    </x-slot>
</x-base-layout>
