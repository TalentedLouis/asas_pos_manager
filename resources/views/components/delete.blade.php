@props(['route'])

@php
    $key = Str::random(10);
@endphp
<form action="{{ $route }}"
      class="inline-block"
      method="post"
      name="{{ 'form_'.$key }}">
    @csrf
    @method('DELETE')
    <a {{ $attributes->merge(['class' => '']) }}
       href="#"
       onclick="{{ 'delete_'.$key.'(); return false;' }}">
        {{ $slot }}
    </a>
</form>

<script type="text/javascript">
    function {{ 'delete_'.$key }}() {
        event.preventDefault();
        if (window.confirm('削除します。よろしいですか？')) {
            document.{{ 'form_'.$key }}.submit();
        }
    }
</script>
