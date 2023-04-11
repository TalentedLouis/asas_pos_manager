<div class="w-full">
    <div class="flex flex-wrap" wire:key="transaction_slip-{{ $transaction_slip->id }}">
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
        
        @foreach($transaction_lines as $index => $transaction_line)
            <div class="flex flex-wrap" wire:key="transaction_line-{{ $index }}">
                <div class="px-1 mb-2 w-1/12">
                    {{-- 商品コード --}}
                    <x-input class="w-full text-sm" type="number"
                        wire:model.lazy="transaction_lines.{{ $index }}.product_code"
                        wire:change.lazy="$emit('changeProduct', {{ $index }}, $event.target.value)" 
                        value="{{ $transaction_line->product_code }}"
                        name="lines[{{ $index }}][product_code]"
                        id="product-code-{{ $index }}"
                        onKeydown="if (event.keyCode == 13) moveCursor(event, {{$index}})"
                        >
                    </x-input>
                </div>
                <div class="px-1 mb-2 w-3/12">
                    {{-- 商品名 --}}
                    <x-input class="w-full text-sm bg-gray-100" type="text" wire:model.lazy="transaction_lines.{{ $index }}.product_name" disabled ></x-input>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    {{-- 数量 --}}
                    <x-input 
                        id="quantity-{{ $index }}"
                        type="number"
                        class="row_quantity w-full text-right text-sm font-bold" 
                        wire:model.lazy="transaction_lines.{{ $index }}.quantity"
                        wire:change="$emit('changeQuantity', {{ $index }}, $event.target.value)"
                        value="{{ number_format($transaction_line->quantity) }}"
                        name="lines[{{ $index }}][quantity]" 
                        onKeydown="if (event.keyCode == 13) moveCursorToPrice(event, {{$index}})"
                        onchange="totalCalc()">
                    </x-input>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    {{-- 単価 --}}
                    <x-input 
                        id="unit-price-{{ $index }}"
                        class="w-full text-right text-sm" 
                        type="number"
                        wire:model.lazy="transaction_lines.{{ $index }}.unit_price"
                        wire:change="$emit('changeUnitPrice', {{ $index }}, $event.target.value)"
                        value="{{ number_format($transaction_line->unit_price) }}"
                        name="lines[{{ $index }}][unit_price]" 
                        onKeydown="if (event.keyCode == 13) moveCursorToModal(event, {{$index}})"
                        onchange="totalCalc()">
                    </x-input>
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
                            <input type="number" class="p-0 m-0 text-xs w-full bg-gray-100 border-gray-100"
                                wire:model.lazy="transaction_lines.{{ $index }}.ctax_price" disabled />
                        </div>
                    </div>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    {{-- 小計 --}}
                    <x-input class="row_subtotal w-full text-right text-sm" type="number"
                            wire:model.lazy="transaction_lines.{{ $index }}.subtotal_tax_included" disabled
                            name="lines[{{ $index }}][subtotal_tax_included]"></x-input>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    {{-- 平均原価 --}}
                    <x-input class="w-full text-right text-sm bg-gray-100" type="number"
                            wire:model.lazy="transaction_lines.{{ $index }}.avg_stocking_price" disabled></x-input>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    {{-- 在庫数 --}}
                    <x-input class="w-full text-right text-sm bg-gray-100" type="number"
                            wire:model.lazy="transaction_lines.{{ $index }}.this_stock_quantity" disabled></x-input>
                </div>
                <div class="px-1 mb-2 w-1/24">
                    {{-- 検索 --}}
                    <x-button 
                        id="open-modal-{{$index}}" 
                        class="bg-blue-500 mr-1" 
                        wire:click.prevent="" 
                        onclick="openModal('{{$index}}', 'edit');"
                        onKeydown="if (event.keyCode == 13) moveCursorToDel(event, {{$index}})"
                        >
                        検索
                    </x-button>
                </div>
                <div class="px-1 mb-2 w-1/12">
                    {{-- 削除 --}}
                    <x-button
                        id="del-{{$index}}"
                        class="bg-gray-600 mr-1" 
                        wire:click.prevent="del({{ $index }})"
                        onKeydown="if (event.keyCode == 13) moveCursor(event, {{$index}})"
                        >
                        削除
                    </x-button>
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
</div>

<script type="text/javascript">
    function openModal(purchaseKey, pageType){
        $('#interestModal').removeClass('invisible');
        localStorage.setItem('purchase_key', purchaseKey);
        localStorage.setItem('page_type', pageType);
    }

    function moveCursor(e, id){
        let currentElement = document.getElementById('product-code-' + id);
        let nextSeq = Number(id) + 1;
        let newId = 'product-code-' + nextSeq;
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
