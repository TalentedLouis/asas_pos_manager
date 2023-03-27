<div class="w-full">
    <div class="flex flex-wrap" wire:key="transaction_slip-{{ $transaction_slip->id }}">
        <input type="hidden" id="transaction_type_id" name="transaction_type_id" value="{{ $transaction_slip->transaction_type_id }}" />
        <div class="px-3 mb-3 w-2/12 sm:w-2/12 lg:w-2/12">
            <x-label for="staff_id" class="w-full" value="担当者No."></x-label>
            <x-input id="staff_id" class="text-sm w-1/3 mr-2" type="text" name="staff_id"
                     wire:model.lazy="transaction_slip.staff_id"
                     wire:change="$emit('changeStaff', $event.target.value)"
                     required autofocus></x-input>
            <x-input wire:model.lazy="transaction_slip.staff_name" class="text-sm w-1/2 mr-2  bg-gray-100" type="text" disabled></x-input>
            <div class="w-full text-red-600 text-sm">
                {{ $staff_message }}
            </div>
        </div>
        <div class="px-3 mb-3 w-3/12 sm:w-3/12 lg:w-3/12">
            @switch($transaction_slip->transaction_type_id)
                @case(1)
                    <x-label for="customer_code" class="w-full" value="会員No."></x-label>
                    <x-input id="target_code" class="text-sm w-1/3 mr-2" type="text" name="target_code"
                            wire:model.lazy="transaction_slip.target_code"
                            wire:change="$emit('changeTarget', $event.target.value)"
                            required></x-input>
                    <x-input id="customer_id" class="text-sm w-1/3 mr-2" type="hidden" name="customer_id"
                            wire:model.lazy="transaction_slip.customer_id" required></x-input>
                    <x-input wire:model.lazy="transaction_slip.target_name" class="text-sm w-1/2 mr-2  bg-gray-100" type="text" disabled></x-input>
                    @break
                @case(2)
                    <x-label for="supplier_target_id" class="w-full" value="仕入先No."></x-label>
                    <x-input id="target_code" class="text-sm w-1/3 mr-2" type="text" name="target_code"
                            wire:model.lazy="transaction_slip.target_code"
                            wire:change="$emit('changeTarget', $event.target.value)"
                            required></x-input>
                    <x-input id="supplier_target_id" class="text-sm w-1/3 mr-2" type="hidden" name="supplier_target_id"
                            wire:model.lazy="transaction_slip.supplier_target_id" required></x-input>
                    <x-input wire:model.lazy="transaction_slip.target_name" class="text-sm w-1/2 mr-2  bg-gray-100" type="text" disabled></x-input>
                    @break
                @case(3)
                    <x-label for="entry_exit_target_id" class="w-full" value="出庫先No."></x-label>
                    <x-input id="target_code" class="text-sm w-1/3 mr-2" type="text" name="target_code"
                            wire:model.lazy="transaction_slip.target_code"
                            wire:change="$emit('changeTarget', $event.target.value)"
                            required></x-input>
                    <x-input id="entry_exit_target_id" class="text-sm w-1/3 mr-2" type="hidden" name="entry_exit_target_id"
                            wire:model.lazy="transaction_slip.entry_exit_target_id"
                            required></x-input>
                    <x-input wire:model.lazy="transaction_slip.target_name" class="text-sm w-1/2 mr-2  bg-gray-100" type="text" disabled></x-input>
                    @break
                @case(4)
                    <x-label for="entry_exit_target_id" class="w-full" value="出庫先No."></x-label>
                    <x-input id="target_code" class="text-sm w-1/3 mr-2" type="text" name="target_code"
                            wire:model.lazy="transaction_slip.target_code"
                            wire:change="$emit('changeTarget', $event.target.value)"
                            required></x-input>
                    <x-input id="entry_exit_target_id" class="text-sm w-1/3 mr-2" type="hidden" name="entry_exit_target_id"
                            wire:model.lazy="transaction_slip.entry_exit_target_id"
                            required></x-input>
                    <x-input wire:model.lazy="transaction_slip.target_name" class="text-sm w-1/2 mr-2  bg-gray-100" type="text" disabled></x-input>
                    @break
            @endswitch
        </div>
        <div class="px-3 mb-3 w-1/12 sm:w-1/12 lg:w-1/12">
            {{-- 合計数量 --}}
            <x-label class="w-full text-right" value="合計数量"></x-label>
            <x-input id="supplier_target_id" wire:model.lazy="transaction_slip.total_quantity" class="w-full text-right text-lg font-bold" type="text" disabled></x-input>
        </div>
        <div class="px-3 mb-3 w-1/12 sm:w-1/12 lg:w-1/12">
            {{-- 税込み合計金額 --}}
            <x-label class="w-full text-right" value="税込み合計金額"></x-label>
            <x-input id="supplier_target_id" wire:model.lazy="transaction_slip.total_amount_ctax_included" class="w-full text-right text-lg font-bold" type="text" disabled></x-input>
        </div>
        
    </div>
    <div class="w-full text-red-600 text-sm">
        {{ $target_message }}
    </div>
    <div class="w-full text-red-600 text-sm">
        {{ $line_message }}
    </div>
    <div class="flex flex-wrap">
        <div class="px-3 mb-1 w-1/12">
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
    
    @foreach($transaction_slip->transaction_lines as $index => $transaction_line)
        <div class="flex flex-wrap" wire:key="transaction_line-{{ $transaction_line->id }}">
            <div class="px-1 mb-2 w-1/12">
                {{-- 商品コード --}}
                <x-input class="w-full text-sm" type="text"
                {{--  2023upd --}}
                {{--  wire:model="transaction_lines.{{ $index }}.product_code"--}}
                         wire:model.lazy="transaction_lines.{{ $index }}.product_code"
                {{--  2023upd --}}
                         wire:change.lazy="$emit('changeProduct', {{ $index }}, $event.target.value)" 
                         value="{{ $transaction_line->product_code }}"
                         name="lines[{{ $index }}][product_code]"></x-input>
            </div>
            <div class="px-1 mb-2 w-3/12">
                {{-- 商品名 --}}
                <x-input class="w-full text-sm bg-gray-100" type="text" wire:model.lazy="transaction_lines.{{ $index }}.product_name" disabled ></x-input>
            </div>
            <div class="px-1 mb-2 w-1/12">
                {{-- 数量 --}}
                <x-input class="row_quantity w-full text-right text-sm font-bold" type="text"
                         wire:model.lazy="transaction_lines.{{ $index }}.quantity"
                         wire:change="$emit('changeQuantity', {{ $index }}, $event.target.value)"
                         value="{{ number_format($transaction_line->quantity) }}"
                         name="lines[{{ $index }}][quantity]" onchange="totalCalc()"></x-input>
            </div>
            <div class="px-1 mb-2 w-1/12">
                {{-- 単価 --}}
                <x-input class="w-full text-right text-sm" type="text"
                         wire:model.lazy="transaction_lines.{{ $index }}.unit_price"
                         wire:change="$emit('changeUnitPrice', {{ $index }}, $event.target.value)"
                         value="{{ number_format($transaction_line->unit_price) }}"
                         name="lines[{{ $index }}][unit_price]" onchange="totalCalc()"></x-input>
            </div>
            <div class="px-1 mb-2 w-1/12">
                <div class="flex flex-wrap">
                    <div class="w-1/2 px-0.5">
                        {{-- 内税 / 外税 --}}
                        @if($transaction_lines[$index]->tax_rate_type_id == \App\Enums\TaxRateType::INCLUDED)
                            <div class="w-full text-xs text-center bg-green-700 text-gray-100 rounded py-0.5">
                                {{ __('Included') }}</div>
                        @elseif($transaction_lines[$index]->tax_rate_type_id == \App\Enums\TaxRateType::EXCLUDED)
                            <div class="w-full text-xs text-center bg-yellow-700 text-gray-100 rounded py-0.5">
                                {{ __('Excluded') }}</div>
                        @endif
                    </div>
                    <div class="w-1/2 px-0.5">
                        {{-- 標準税率 / 軽減税率 --}}
                        @if($transaction_lines[$index]->taxable_method_type_id == \App\Enums\TaxableMethodType::STANDARD_TAX)
                            <div class="w-full text-xs text-center bg-blue-700 text-gray-100 rounded py-0.5">
                                {{ __('Standard tax short') }}</div>
                        @elseif($transaction_lines[$index]->taxable_method_type_id == \App\Enums\TaxableMethodType::REDUCED_TAX)
                            <div class="w-full text-xs text-center bg-red-700 text-gray-100 rounded py-0.5">
                                {{ __('Reduced tax short') }}</div>
                        @elseif($transaction_lines[$index]->taxable_method_type_id == \App\Enums\TaxableMethodType::NONE_TAX)
                            <div class="w-full text-xs text-center bg-gray-700 text-gray-100 rounded py-0.5">
                                {{ __('None tax') }}</div>
                        @endif
                    </div>
                    <div class="w-full px-0.5 text-xs">
                        {{-- 税額 --}}
                        <input type="text" class="p-0 m-0 text-xs w-full bg-gray-100 border-gray-100"
                               wire:model.lazy="transaction_lines.{{ $index }}.ctax_price" disabled />
                    </div>
                </div>
            </div>
            <div class="px-1 mb-2 w-1/12">
                {{-- 小計 --}}
                <x-input class="row_subtotal w-full text-right text-sm" type="text"
                         wire:model.lazy="transaction_lines.{{ $index }}.subtotal_tax_included" disabled
                         name="lines[{{ $index }}][subtotal_tax_included]"></x-input>
            </div>
            <div class="px-1 mb-2 w-1/12">
                {{-- 平均原価 --}}
                <x-input class="w-full text-right text-sm bg-gray-100" type="text"
                         wire:model.lazy="transaction_lines.{{ $index }}.avg_stocking_price" disabled></x-input>
            </div>
            <div class="px-1 mb-2 w-1/12">
                {{-- 在庫数 --}}
                <x-input class="w-full text-right text-sm bg-gray-100" type="text"
                         wire:model.lazy="transaction_lines.{{ $index }}.this_stock_quantity" disabled></x-input>
            </div>
            <div class="px-1 mb-2 w-1/24">
                {{-- 検索 --}}
                <x-button class="bg-blue-500 mr-1" wire:click.prevent="" onclick="openModal('{{$index}}', 'edit');">検索</x-button>
            </div>
            <div class="px-1 mb-2 w-1/12">
                {{-- 削除 --}}
                <x-button class="bg-gray-600 mr-1" wire:click.prevent="del({{ $index }})">削除</x-button>
            </div>
            <x-input name="lines[{{ $index }}][product_id]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.product_id" />
            <x-input name="lines[{{ $index }}][product_name]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.product_name" />
            <x-input name="lines[{{ $index }}][avg_stocking_price]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.avg_stocking_price" />
            <x-input name="lines[{{ $index }}][this_stock_quantity]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.this_stock_quantity" />
            <x-input class="row_exclude_tax" name="lines[{{ $index }}][exclude_tax]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.exclude_tax" />
            <x-input name="lines[{{ $index }}][include_tax]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.include_tax" />
            <x-input name="lines[{{ $index }}][tax_rate_type_id]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.tax_rate_type_id" />
            <x-input name="lines[{{ $index }}][taxable_method_type_id]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.taxable_method_type_id" />
            <x-input name="lines[{{ $index }}][final_unit_price_tax_included]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.final_unit_price_tax_included" />
            <x-input name="lines[{{ $index }}][final_unit_price_tax_excluded]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.final_unit_price_tax_excluded" />
            <x-input name="lines[{{ $index }}][subtotal_tax_included]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.subtotal_tax_included" />
            <x-input name="lines[{{ $index }}][subtotal_tax_excluded]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.subtotal_tax_excluded" />
            <x-input name="lines[{{ $index }}][ctax_price]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.ctax_price" />
            <x-input name="lines[{{ $index }}][ctax_rate]" type="hidden" wire:model.lazy="transaction_lines.{{ $index }}.ctax_rate" />
        </div>
    @endforeach
    {{-- 2023 ADD S --}}
    <div class="w-full text-red-600 text-sm">
        {{ $test_message }}
    </div>
</div>

<script type="text/javascript">
    function openModal(purchaseKey, pageType){
        $('#interestModal').removeClass('invisible');
        localStorage.setItem('purchase_key', purchaseKey);
        localStorage.setItem('page_type', pageType);
    }
</script>
