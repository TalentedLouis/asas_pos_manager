<div class="w-full">
    <div class="flex flex-wrap">
        <input type="hidden" id="transaction_type_id" name="transaction_type_id" value="{{$transaction_type_id}}" />
        {{-- 担当者 --}}
        <div class="px-3 mb-3 w-2/12 sm:w-2/12 lg:w-2/12">
            <x-label for="staff_id" class="w-full" value="担当者No."></x-label>
            <x-input id="staff_id" class="text-sm w-1/3 mr-2" type="number" name="staff_id" wire:model.lazy="slip.staff_id" required autofocus></x-input>
            <x-value class="w-2/3">{{ $slip->staff ? $slip->staff->name : '' }}</x-value>
        </div>
        {{-- 相手先 --}}
        @switch($slip->transaction_type_id)
            @case(1)
                <div class="px-3 mb-3 w-3/12 sm:w-3/12 lg:w-3/12">  
                    <x-label for="customer_code" class="w-full" value="会員No."></x-label>
                    <x-input id="target_code" class="text-sm w-4/12 mr-2" type="number" name="target_code"
                            wire:model.lazy="slip.target_code"
                            wire:change="$emit('changeTarget', $event.target.value)"
                            required></x-input>
                    <x-input id="customer_id" class="text-sm w-0/12 mr-2" type="hidden" name="customer_id" wire:model.lazy="slip.customer_id" ></x-input>
                    <x-input id="target_name" class="text-sm w-7/12 mr-2 bg-gray-100" type="text" name="target_name" wire:model.lazy="slip.target_name" disabled></x-input>
                </div>
                @break
            @case(2)
                <div class="px-3 mb-3 w-3/12 sm:w-3/12 lg:w-3/12">
                    <x-label for="supplier_target_id" class="w-full" value="仕入先No."></x-label>
                    <x-input id="target_code" class="text-sm w-4/12 mr-2" type="number" name="target_code"
                            wire:model.lazy="slip.target_code"
                            wire:change="$emit('changeTarget', $event.target.value)"
                            required></x-input>
                    <x-input id="supplier_target_id" class="text-sm w-1/3 mr-2" type="hidden" name="supplier_target_id" wire:model.lazy="slip.supplier_target_id" ></x-input>
                    <x-input id="target_name" class="text-sm w-7/12 mr-2 bg-gray-100" type="text" name="target_name" wire:model.lazy="slip.target_name" disabled></x-input>
                </div>
                @break
            @case(3)
                <div class="px-3 mb-3 w-3/12 sm:w-3/12 lg:w-3/12">
                    <x-label for="entry_exit_target_id" class="w-full" value="入出庫No."></x-label>
                    <x-input id="target_code" class="text-sm w-4/12 mr-2" type="number" name="target_code"
                            wire:model.lazy="slip.target_code"
                            wire:change="$emit('changeTarget', $event.target.value)"
                            required></x-input>
                    <x-input id="entry_exit_target_id" class="text-sm w-1/3 mr-2" type="hidden" name="entry_exit_target_id" wire:model.lazy="slip.entry_exit_target_id" ></x-input>
                    <x-input id="target_name" class="text-sm w-7/12 mr-2 bg-gray-100" type="text" name="target_name" wire:model.lazy="slip.target_name" disabled></x-input>
                </div>
                @break
            @case(4)
                <div class="px-3 mb-3 w-3/12 sm:w-3/12 lg:w-3/12">
                    <x-label for="entry_exit_target_id" class="w-full" value="入出庫No."></x-label>
                    <x-input id="target_code" class="text-sm w-4/12 mr-2" type="number" name="target_code"
                            wire:model.lazy="slip.target_code"
                            wire:change="$emit('changeTarget', $event.target.value)"
                            required></x-input>
                    <x-input id="entry_exit_target_id" class="text-sm w-1/3 mr-2" type="hidden" name="entry_exit_target_id" wire:model.lazy="slip.entry_exit_target_id" ></x-input>
                    <x-input id="target_name" class="text-sm w-7/12 mr-2 bg-gray-100" type="text" name="target_name" wire:model.lazy="slip.target_name" disabled></x-input>
                </div>
                @break
            @default
        @endswitch
        {{-- ヘッダー合計 --}}
        @if($slip->transaction_type_id === 5 or $slip->transaction_type_id === 6)
            <div class="px-3 mb-3 w-1/12 sm:w-1/12 lg:w-1/12">
            </div>
            <div class="px-3 mb-3 w-1/12 sm:w-1/12 lg:w-1/12">
                {{-- 合計金額 --}}
                <x-label class="w-full text-right" value="金額"></x-label>
                <div class="w-full text-right text-lg font-bold">    
                    {{ number_format($total_subtotal_tax_included) }}
                </div>
            </div>
        @else
            <div class="px-3 mb-3 w-1/12 sm:w-1/12 lg:w-1/12">
                {{-- 合計数量 --}}
                <x-label class="w-full text-right" value="合計数量"></x-label>
                <div class="w-full text-right text-lg font-bold">    
                    {{ number_format($total_quantity) }}
                </div>
            </div>
            <div class="px-3 mb-3 w-1/12 sm:w-1/12 lg:w-1/12">
                {{-- 内税金額 --}}
                <x-label class="w-full text-right" value="内税金額"></x-label>
                <div class="w-full text-right text-lg font-bold">    
                    {{ number_format($total_include_tax) }}
                </div>
            </div>
            <div class="px-3 mb-3 w-1/12 sm:w-1/12 lg:w-1/12">
                {{-- 外税金額 --}}
                <x-label class="w-full text-right" value="外税金額"></x-label>
                <div class="w-full text-right text-lg font-bold">    
                    {{ number_format($total_exclude_tax) }}
                </div>
            </div>
            <div class="px-3 mb-3 w-1/12 sm:w-1/12 lg:w-1/12">
                {{-- 合計金額 --}}
                <x-label class="w-full text-right" value="税込み合計金額"></x-label>
                <div class="w-full text-right text-lg font-bold">    
                    {{ number_format($total_subtotal_tax_included) }}
                </div>
            </div>
        @endif
    </div>
    <div class="w-full text-red-600 text-sm">
        {{ $test_message }}
    </div>
    {{-- 明細データ --}}
    @if($slip->transaction_type_id === 5 or $slip->transaction_type_id === 6)
        {{-- 入出金の場合 --}}
        <div class="flex flex-wrap">
            <div class="px-3 mb-1 w-3/12">
                <x-label class="w-full" value="入出金 詳細"></x-label>
            </div>
            <div class="px-3 mb-1 w-1/12">
                <x-label class="w-full" value="金額"></x-label>
            </div>
        </div>
        @foreach($lines as $key => $value)
            <div class="flex flex-wrap slip-product" id="slip-{{$key}}">
                <div class="px-1 mb-2 w-3/12">
                    {{-- 備考1 --}}
                    <x-input id="note-{{$key}}" class="w-full text-sm " type="text" name="lines[{{ $key }}][note]"></x-input>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    {{-- 単価 --}}
                    <x-input 
                        id="unit-price-{{ $key }}"
                        class="w-full text-right text-sm" 
                        type="number" 
                        name="lines[{{ $key }}][unit_price]"
                        wire:model.lazy="unit_price.{{ $key }}"
                        wire:change="$emit('changeUnitPrice', {{ $key }}, $event.target.value)"
                        onKeydown="if (event.keyCode == 13) moveCursorToNote(event, {{$key}})"
                        >
                    </x-input>
                    {{--
                    <x-input class="w-full text-right text-sm" type="text" wire:model.lazy="unit_price.{{ $key }}"
                            name="lines[{{ $key }}][unit_price]"></x-input>
                    --}}
                </div>
                <x-input name="lines[{{ $key }}][product_id]" type="hidden" wire:model.lazy="product_id.{{ $key }}" />
                <x-input name="lines[{{ $key }}][category_id]" type="hidden" wire:model.lazy="category_id.{{ $key }}" />
                <x-input name="lines[{{ $key }}][genre_id]" type="hidden" wire:model.lazy="genre_id.{{ $key }}" />
                <x-input name="lines[{{ $key }}][product_code]" type="hidden" wire:model.lazy="product_code.{{ $key }}" />
                <x-input name="lines[{{ $key }}][product_name]" type="hidden" wire:model.lazy="product_name.{{ $key }}" />
                <x-input name="lines[{{ $key }}][quantity]" type="hidden" wire:model.lazy="quantity.{{ $key }}" />
                <x-input name="lines[{{ $key }}][avg_stocking_price]" type="hidden" wire:model.lazy="avg_stocking_price.{{ $key }}" />
                <x-input name="lines[{{ $key }}][this_stock_quantity]" type="hidden" wire:model.lazy="this_stock_quantity.{{ $key }}" />
                <x-input class="row_exclude_tax" name="lines[{{ $key }}][exclude_tax]" type="hidden" wire:model.lazy="exclude_tax.{{ $key }}" />
                <x-input name="lines[{{ $key }}][include_tax]" type="hidden" wire:model.lazy="include_tax.{{ $key }}" />
                <x-input name="lines[{{ $key }}][tax_rate_type_id]" type="hidden" wire:model.lazy="tax_rate_type_id.{{ $key }}" />
                <x-input name="lines[{{ $key }}][taxable_method_type_id]" type="hidden" wire:model.lazy="taxable_method_type_id.{{ $key }}" />
                <x-input name="lines[{{ $key }}][final_unit_price_tax_included]" type="hidden" wire:model.lazy="final_unit_price_tax_included.{{ $key }}" />
                <x-input name="lines[{{ $key }}][final_unit_price_tax_excluded]" type="hidden" wire:model.lazy="final_unit_price_tax_excluded.{{ $key }}" />
                <x-input name="lines[{{ $key }}][subtotal_tax_included]" type="hidden" wire:model.lazy="subtotal_tax_included.{{ $key }}" />
                <x-input name="lines[{{ $key }}][subtotal_tax_excluded]" type="hidden" wire:model.lazy="subtotal_tax_excluded.{{ $key }}" />
                <x-input name="lines[{{ $key }}][ctax_price]" type="hidden" wire:model.lazy="ctax_price.{{ $key }}" />
                <x-input name="lines[{{ $key }}][ctax_rate]" type="hidden" wire:model.lazy="ctax_rate.{{ $key }}" />
                <!-- This example requires Tailwind CSS v2.0+ -->
            </div>
        @endforeach 
    @else
        {{-- 通常(売上・仕入・入出庫等)の場合 --}}
        <div class="flex flex-wrap">
            <div class="px-3 mb-1 w-2/12">
                <x-label class="w-full" value="商品コード"></x-label>
            </div>
            <div class="px-3 mb-1 w-3/12">
                <x-label class="w-full" value="商品名"></x-label>
            </div>
            <div class="px-3 mb-1 w-1/12">
                <x-label class="w-full" value="数量"></x-label>
            </div>
            <div class="px-3 mb-1 w-1/12">
                <x-label class="w-full" value="単価"></x-label>
            </div>
            <div class="px-3 mb-1 w-1/12">
                <x-label class="w-full" value="消費税"></x-label>
            </div>
            <div class="px-3 mb-1 w-1/12">
                <x-label class="w-full" value="金額"></x-label>
            </div>
            <div class="px-3 mb-1 w-1/12">
                <x-label class="w-full" value="原価"></x-label>
            </div>
            <div class="px-3 mb-1 w-1/12">
                <x-label class="w-full" value="在庫数"></x-label>
            </div>
        </div>
        @foreach($lines as $key => $value)
            <div class="flex flex-wrap slip-product" id="slip-{{$key}}">
                <div class="px-1 mb-2 w-2/12">
                    {{-- 商品コード --}}
                    <x-input 
                        type="number" 
                        id="line-{{$key}}"
                        class="w-full text-sm" 
                        wire:model.lazy="product_code.{{ $key }}"
                        wire:change.lazy="$emit('changeProduct', {{ $key }}, $event.target.value)"
                        name="lines[{{ $key }}][product_code]"
                        onKeydown="if (event.keyCode == 13) moveCursor(event, {{$key}})"
                        >
                    </x-input>
                </div>
                <div class="px-1 mb-2 w-3/12">
                    {{-- 商品名 --}}
                    <x-input class="w-full text-sm bg-gray-100" type="text" wire:model.lazy="product_name.{{ $key }}" disabled></x-input>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    {{-- 数量 --}}
                    <x-input 
                        id="quantity-{{ $key }}"
                        class="row_quantity w-full text-right text-sm font-bold" 
                        type="number" 
                        wire:model.lazy="quantity.{{ $key }}"
                        name="lines[{{ $key }}][quantity]"
                        {{-- wire:change="$emit('changeQuantity', {{ $key }}, $event.target.value)"--}}
                        onKeydown="if (event.keyCode == 13) moveCursorToPrice(event, {{$key}})"
                        >
                    </x-input>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    {{-- 単価 --}}
                    <x-input 
                        id="unit-price-{{ $key }}"
                        class="w-full text-right text-sm" 
                        type="number" 
                        name="lines[{{ $key }}][unit_price]"
                        wire:model.lazy="unit_price.{{ $key }}"
                        {{-- wire:change="$emit('changeUnitPrice', {{ $key }}, $event.target.value)" --}}
                        onKeydown="if (event.keyCode == 13) moveCursorToModal(event, {{$key}})"
                        >
                    </x-input>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    <div class="flex flex-wrap">
                        <div class="w-1/2 px-0.5">
                            {{-- 内税 / 外税 --}}
                            @if(array_key_exists($key, $tax_rate_type_id))
                                @if($tax_rate_type_id[$key] == \App\Enums\TaxRateType::INCLUDED)
                                    <div class="w-full text-xs text-center bg-green-700 text-gray-100 rounded py-0.5">
                                        {{ __('Included') }}</div>
                                @elseif($tax_rate_type_id[$key] == \App\Enums\TaxRateType::EXCLUDED)
                                    <div class="w-full text-xs text-center bg-yellow-700 text-gray-100 rounded py-0.5">
                                        {{ __('Excluded') }}</div>
                                @endif
                            @endif
                        </div>
                        <div class="w-1/2 px-0.5">
                            {{-- 標準税率 / 軽減税率 --}}
                            @if(array_key_exists($key, $taxable_method_type_id))
                                @if($taxable_method_type_id[$key] == \App\Enums\TaxableMethodType::STANDARD_TAX)
                                    <div class="w-full text-xs text-center bg-blue-700 text-gray-100 rounded py-0.5">
                                        {{ __('Standard tax short') }}</div>
                                @elseif($taxable_method_type_id[$key] == \App\Enums\TaxableMethodType::REDUCED_TAX)
                                    <div class="w-full text-xs text-center bg-red-700 text-gray-100 rounded py-0.5">
                                        {{ __('Reduced tax short') }}</div>
                                @elseif($taxable_method_type_id[$key] == \App\Enums\TaxableMethodType::NONE_TAX)
                                    <div class="w-full text-xs text-center bg-gray-700 text-gray-100 rounded py-0.5">
                                        {{ __('None tax') }}</div>
                                @endif
                            @endif
                        </div>
                        <div class="w-full px-0.5 text-xs">
                            {{-- 税額 --}}
                            @if(array_key_exists($key, $ctax_price))
                                {{ $ctax_price[$key] }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    {{-- 小計 --}}
                    <x-input class="row_subtotal w-full text-right text-sm" type="number" wire:model.lazy="subtotal_tax_included.{{ $key }}" disabled
                            name="lines[{{ $key }}][subtotal_tax_included]"></x-input>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    {{-- 平均原価 --}}
                    <x-input class="w-full text-right text-sm bg-gray-100" type="number" wire:model.lazy="avg_stocking_price.{{ $key }}" disabled></x-input>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    {{-- 在庫数 --}}
                    <x-input class="w-full text-right text-sm bg-gray-100" type="number" wire:model.lazy="this_stock_quantity.{{ $key }}" disabled></x-input>
                </div>
                <div class="px-1 mb-2 w-1/24">
                    {{-- 検索 --}}
                    <x-button 
                        id="open-modal-{{$key}}" 
                        class="bg-blue-500 mr-1" 
                        wire:click.prevent="" 
                        onclick="openModal('{{$key}}', 'create');"
                        onKeydown="if (event.keyCode == 13) moveCursorToDel(event, {{$key}})"
                        >
                        検索
                    </x-button>
                </div>
                <div class="px-1 mb-2 w-1/24">
                    {{-- 削除 --}}
                    <x-button
                        id="del-{{$key}}"
                        class="bg-red-500 mr-1" 
                        wire:click.prevent="del({{ $key }})"
                        onKeydown="if (event.keyCode == 13) moveCursor(event, {{$key}})"
                        >
                        削除
                    </x-button>
                </div>
                <!-- This example requires Tailwind CSS v2.0+ -->
            </div>

            <x-input name="lines[{{ $key }}][product_id]" type="hidden" wire:model.lazy="product_id.{{ $key }}" />
            <x-input name="lines[{{ $key }}][category_id]" type="hidden" wire:model.lazy="category_id.{{ $key }}" />
            <x-input name="lines[{{ $key }}][genre_id]" type="hidden" wire:model.lazy="genre_id.{{ $key }}" />
            <x-input name="lines[{{ $key }}][product_name]" type="hidden" wire:model.lazy="product_name.{{ $key }}" />
            <x-input name="lines[{{ $key }}][avg_stocking_price]" type="hidden" wire:model.lazy="avg_stocking_price.{{ $key }}" />
            <x-input name="lines[{{ $key }}][this_stock_quantity]" type="hidden" wire:model.lazy="this_stock_quantity.{{ $key }}" />
            <x-input class="row_exclude_tax" name="lines[{{ $key }}][exclude_tax]" type="hidden" wire:model.lazy="exclude_tax.{{ $key }}" />
            <x-input name="lines[{{ $key }}][include_tax]" type="hidden" wire:model.lazy="include_tax.{{ $key }}" />
            <x-input name="lines[{{ $key }}][tax_rate_type_id]" type="hidden" wire:model.lazy="tax_rate_type_id.{{ $key }}" />
            <x-input name="lines[{{ $key }}][taxable_method_type_id]" type="hidden" wire:model.lazy="taxable_method_type_id.{{ $key }}" />
            <x-input name="lines[{{ $key }}][final_unit_price_tax_included]" type="hidden" wire:model.lazy="final_unit_price_tax_included.{{ $key }}" />
            <x-input name="lines[{{ $key }}][final_unit_price_tax_excluded]" type="hidden" wire:model.lazy="final_unit_price_tax_excluded.{{ $key }}" />
            <x-input name="lines[{{ $key }}][subtotal_tax_included]" type="hidden" wire:model.lazy="subtotal_tax_included.{{ $key }}" />
            <x-input name="lines[{{ $key }}][subtotal_tax_excluded]" type="hidden" wire:model.lazy="subtotal_tax_excluded.{{ $key }}" />
            <x-input name="lines[{{ $key }}][ctax_price]" type="hidden" wire:model.lazy="ctax_price.{{ $key }}" />
            <x-input name="lines[{{ $key }}][ctax_rate]" type="hidden" wire:model.lazy="ctax_rate.{{ $key }}" />
        @endforeach
    @endif
</div>

<script type="text/javascript">
    function openModal(purchaseKey, pageType){
        $('#interestModal').removeClass('invisible');
        localStorage.setItem('purchase_key', purchaseKey);
        localStorage.setItem('page_type', pageType);
        setTimeout(function(){
            document.getElementById('keyword').focus();
        },700);
    }

    function moveCursor(e, id){
        let currentElement = document.getElementById('line-' + id);
        let nextSeq = Number(id) + 1;
        let newId = 'line-' + nextSeq;
        let nextElement = document.getElementById(newId);
        if (nextElement) nextElement.focus();
        
        e.preventDefault();        
    }
    function moveCursorToPrice(e, id){
        let nextElement = document.getElementById('unit-price-' + id);
        if (nextElement) nextElement.focus();
        
        e.preventDefault();
    }
    function moveCursorToModal(e, id){
        let nextElement = document.getElementById('open-modal-' + id);
        if (nextElement) nextElement.focus();
        
        e.preventDefault();
    }
    function moveCursorToDel(e, id){
        let nextElement = document.getElementById('del-' + id);
        if (nextElement) nextElement.focus();
        
        e.preventDefault();
    }
    function moveCursorToNote(e, id){
        let nextElement = document.getElementById('note-' + id);
        if (nextElement) nextElement.focus();
        
        e.preventDefault();
    }
</script>
