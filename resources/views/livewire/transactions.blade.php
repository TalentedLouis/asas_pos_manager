<div class="w-full">
    <div class="flex flex-wrap">
        <input type="hidden" id="transaction_type_id" name="transaction_type_id" value="{{$transaction_type_id}}" />
        <div class="px-3 mb-3 w-2/12 sm:w-2/12 lg:w-2/12">
            <x-label for="staff_id" class="w-full" value="担当者No."></x-label>
            <x-input id="staff_id" class="text-sm w-1/3 mr-2" type="text" name="staff_id" wire:model.lazy="slip.staff_id" required autofocus></x-input>
            <x-value class="w-2/3">{{ $slip->staff ? $slip->staff->name : '' }}</x-value>
        </div>
        <div class="px-3 mb-3 w-3/12 sm:w-3/12 lg:w-3/12">
            @switch($slip->transaction_type_id)
                @case(1)
                    <x-label for="customer_id" class="w-full" value="会員No."></x-label>
                    <x-input id="customer_id" class="text-sm w-1/3 mr-2" type="text" name="customer_id" wire:model.lazy="slip.customer_id" ></x-input>
                    <x-value class="w-2/3">{{ $slip->customer ? $slip->customer->name : '' }}</x-value>
                    @break
                @case(2)
                    <x-label for="supplier_target_id" class="w-full" value="仕入先No."></x-label>
                    <x-input id="supplier_target_id" class="text-sm w-1/3 mr-2" type="text" name="supplier_target_id" wire:model.lazy="slip.supplier_target_id" ></x-input>
                    <x-value class="w-2/3">{{ $slip->supplier_target ? $slip->supplier_target->name : '' }}</x-value>
                    @break
                @case(3)
                    <x-label for="entry_exit_target_id" class="w-full" value="入出庫No."></x-label>
                    <x-input id="entry_exit_target_id" class="text-sm w-1/3 mr-2" type="text" name="entry_exit_target_id" wire:model.lazy="slip.entry_exit_target_id" ></x-input>
                    <x-value class="w-2/3">{{ $slip->entry_exit_target ? $slip->entry_exit_target->name : '' }}</x-value>
                    @break
                @case(4)
                    <x-label for="entry_exit_target_id" class="w-full" value="入出庫No."></x-label>
                    <x-input id="entry_exit_target_id" class="text-sm w-1/3 mr-2" type="text" name="entry_exit_target_id" wire:model.lazy="slip.entry_exit_target_id" ></x-input>
                    <x-value class="w-2/3">{{ $slip->entry_exit_target ? $slip->entry_exit_target->name : '' }}</x-value>
                    @break
            @endswitch
        </div>
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
    </div>
    {{--
    <div class="w-full text-red-600">
        {{ $slip->transaction_type_id }}
    </div>
    <div class="w-full text-red-600">
        {{ $total_quantity }}
    </div>
    --}}
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
        <div class="flex flex-wrap">
            <div class="px-1 mb-2 w-2/12">
                {{-- 商品コード --}}
                <x-input class="w-full text-sm" type="text" 
                         wire:model.lazy="product_code.{{ $key }}"
                         wire:change.lazy="$emit('changeProduct', {{ $key }}, $event.target.value)"
                         name="lines[{{ $key }}][product_code]"></x-input>
                {{--
                <x-input class="w-full text-sm" type="text" wire:model.lazy="product_code.{{ $key }}"
                         name="lines[{{ $key }}][product_code]"></x-input>
                --}}
                {{--         
                
                    <x-input class="w-full text-sm" type="text"
                         wire:model.lazy="transaction_lines.{{ $index }}.product_code"
                         wire:change.lazy="$emit('changeProduct', {{ $index }}, $event.target.value)"
                         value="{{ $transaction_line->product_code }}"
                         name="lines[{{ $index }}][product_code]"></x-input>
                --}}
            </div>
            <div class="px-1 mb-2 w-3/12">
                {{-- 商品名 --}}
                <x-input class="w-full text-sm bg-gray-100" type="text" wire:model.lazy="product_name.{{ $key }}" disabled></x-input>
            </div>
            <div class="px-1 mb-2 w-1/12">
                {{-- 数量 --}}
                <x-input class="row_quantity w-full text-right text-sm font-bold" type="text" wire:model.lazy="quantity.{{ $key }}"
                         name="lines[{{ $key }}][quantity]"></x-input>
            </div>
            <div class="px-1 mb-2 w-1/12">
                {{-- 単価 --}}
                <x-input class="w-full text-right text-sm" type="text" wire:model.lazy="unit_price.{{ $key }}"
                         name="lines[{{ $key }}][unit_price]"></x-input>
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
                {{-- 2023UPD
                <x-input class="row_subtotal w-full text-right text-sm" type="text" wire:model.lazy="subtotal_tax_included.{{ $key }}"
                         name="lines[{{ $key }}][subtotal_tax_included]"></x-input>
                --}}
                <x-input class="row_subtotal w-full text-right text-sm" type="text" wire:model.lazy="subtotal_tax_included.{{ $key }}" disabled
                         name="lines[{{ $key }}][subtotal_tax_included]"></x-input>
            </div>
            <div class="px-1 mb-2 w-1/12">
                {{-- 平均原価 --}}
                <x-input class="w-full text-right text-sm bg-gray-100" type="text" wire:model.lazy="avg_stocking_price.{{ $key }}" disabled></x-input>
            </div>
            <div class="px-1 mb-2 w-1/12">
                {{-- 在庫数 --}}
                <x-input class="w-full text-right text-sm bg-gray-100" type="text" wire:model.lazy="this_stock_quantity.{{ $key }}" disabled></x-input>
            </div>
            <div class="px-1 mb-2 w-1/24">
                {{-- 検索 --}}
                <x-button class="bg-blue-500 mr-1" wire:click.prevent="del({{ $index }},{{ $key }})">検索</x-button>
            </div>
            <div class="px-1 mb-2 w-1/24">
                {{-- 削除 --}}
            <x-button class="bg-red-500 mr-1" wire:click.prevent="del({{ $index }},{{ $key }})">削除</x-button>
            </div>
        </div>
        <x-input name="lines[{{ $key }}][product_id]" type="hidden" wire:model.lazy="product_id.{{ $key }}" />
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
        {{--
        <div class="w-full text-red-600 text-sm">
            {{ $key }}
        </div>
        --}}
    @endforeach
    
    {{--
    <div class="flex flex-wrap px-1 mb-2">
        <x-button class="bg-gray-600 mr-1" wire:click.prevent="add({{ $index }}, 5)">5行 追加</x-button>
        <x-button class="bg-gray-600 mr-1" wire:click.prevent="add({{ $index }}, 10)">10行 追加</x-button>
    </div>
    --}}
</div>