@props(['items', 'selected'])

<select {{ $attributes->merge(['class' => 'w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) }}>
    {{-- <option>選択してください</option> --}}
    <option value="{{ NULL }}">選択してください</option>
    @foreach ($items as $id => $name)
        <option value="{{ $id }}" {{ $selected == $id ? 'selected="selected"' : '' }}>{{ __($name) }}</option>
    @endforeach
</select>
