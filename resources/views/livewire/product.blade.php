<div class="w-full">
    <div class="flex flex-wrap">
        <div class="px-1 mb-2 w-2/12">
            {{-- 商品コード --}}
            <x-input class="w-full text-sm" type="text" name="products[{{ $i }}][product_code]" wire:model.lazy="product_code" :value="old('products[{{ $i }}][product_code]', $product_code)" />
        </div>
        <div class="px-1 mb-2 w-3/12">
            {{-- 商品名 --}}
            <x-input class="w-full text-sm bg-gray-100" type="text" value="{{ $name }}" disabled />
        </div>
        <div class="px-1 mb-2 w-1/12">
            {{-- 数量 --}}
            <x-input class="row_quantity w-full text-sm font-bold" type="text" name="products[{{ $i }}][quantity]" wire:model.lazy="quantity" :value="old('products[{{ $i }}][quantity]', $quantity)" />
        </div>
        <div class="px-1 mb-2 w-1/12">
            {{-- 単価 --}}
            <x-input class="w-full text-sm" type="text" name="products[{{ $i }}][unit_price]" wire:model.lazy="unit_price" :value="old('products[{{ $i }}][unit_price]', $unit_price)" />
        </div>
        <div class="px-1 mb-2 w-1/12">
            <div class="flex flex-wrap">
                <div class="w-1/2 px-0.5">
                    {{-- 内税 / 外税 --}}
                    @if($tax_rate_type_id == \App\Enums\TaxRateType::INCLUDED)
                        <div class="w-full text-xs text-center bg-green-700 text-gray-100 rounded-sm py-0.5">{{ __('Included') }}</div>
                    @elseif($tax_rate_type_id == \App\Enums\TaxRateType::EXCLUDED)
                        <div class="w-full text-xs text-center bg-yellow-700 text-gray-100 rounded-sm py-0.5">{{ __('Excluded') }}</div>
                    @endif
                </div>
                <div class="w-1/2 px-0.5">
                    {{-- 標準税率 / 軽減税率 --}}
                    @if($taxable_method_type_id == \App\Enums\TaxableMethodType::STANDARD_TAX)
                        <div class="w-full text-xs text-center bg-blue-700 text-gray-100 rounded-sm py-0.5">{{ __('Standard tax short') }}</div>
                    @elseif($taxable_method_type_id == \App\Enums\TaxableMethodType::REDUCED_TAX)
                        <div class="w-full text-xs text-center bg-red-700 text-gray-100 rounded-sm py-0.5">{{ __('Reduced tax short') }}</div>
                    @elseif($taxable_method_type_id == \App\Enums\TaxableMethodType::NONE_TAX)
                        <div class="w-full text-xs text-center bg-gray-700 text-gray-100 rounded-sm py-0.5">{{ __('None tax') }}</div>
                    @endif
                </div>
                <div class="w-full px-0.5 text-xs">
                    {{-- 税額 --}}
                    {{ $ctax_price }}
                    <x-input class="row_exclude_tax" type="hidden" value="{{ $exclude_tax }}" />
                </div>
            </div>
        </div>
        <div class="px-1 mb-2 w-1/12">
            {{-- 小計 --}}
            <x-input class="row_subtotal w-full text-sm font-bold" type="text" name="products[{{ $i }}][subtotal_tax_included]" wire:model.lazy="subtotal_tax_included" :value="old('products[{{ $i }}][subtotal_tax_included]', $subtotal_tax_included)" />
        </div>
        <div class="px-1 mb-2 w-1/12">
            {{-- 平均原価 --}}
            <x-input class="w-full text-sm bg-gray-100" type="text" value="{{ $avg_stocking_price }}" disabled />
        </div>
        <div class="px-1 mb-2 w-1/12">
            {{-- 在庫数 --}}
            <x-input class="w-full text-sm bg-gray-100" type="text" value="{{ $this_stock_quantity }}" disabled />
        </div>
    </div>
    <x-input name="products[{{ $i }}][tax_rate_type_id]" type="hidden" value="{{ $tax_rate_type_id }}" />
    <x-input name="products[{{ $i }}][taxable_method_type_id]" type="hidden" value="{{ $taxable_method_type_id }}" />
    <x-input name="products[{{ $i }}][final_unit_price_tax_included]" type="hidden" value="{{ $final_unit_price_tax_included }}" />
    <x-input name="products[{{ $i }}][final_unit_price_tax_excluded]" type="hidden" value="{{ $final_unit_price_tax_excluded }}" />
    <x-input name="products[{{ $i }}][subtotal_tax_included]" type="hidden" value="{{ $subtotal_tax_included }}" />
    <x-input name="products[{{ $i }}][subtotal_tax_excluded]" type="hidden" value="{{ $subtotal_tax_excluded }}" />
    <x-input name="products[{{ $i }}][ctax_price]" type="hidden" value="{{ $ctax_price }}" />
    <x-input name="products[{{ $i }}][ctax_rate]" type="hidden" value="{{ $ctax_rate }}" />
</div>
