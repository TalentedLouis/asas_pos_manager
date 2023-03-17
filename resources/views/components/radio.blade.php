<div class="inline-block mt-1.5">
    <input type="radio" value="{{ $value }}" id="{{ $id }}" {{ $value === $input ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'inline-block mr-2 appearance-none rounded-full h-6 w-6 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer']) !!}>
    <label class="inline-block mr-3 mt-0.5 text-gray-800 {{ $disabled ? 'text-opacity-50' : '' }}" for="{{ $id }}">{{ $slot }}</label>
</div>
