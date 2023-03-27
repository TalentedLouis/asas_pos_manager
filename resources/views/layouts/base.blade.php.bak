<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" />
        <script src="{{ asset('js/app.js') }}" defer></script>
        
        {{--  2023add  --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>    
        $(() => {
            // :focusable はマイナスのtabindexを含む
            //  ⇒enter時に次項目へ移動するためのイベント対象のため含めている。
            const elements = ':focusable:not(a)';
            $(elements).keypress((e) => {
            if (e.key === 'Enter' || e.key === '\n') {
                if (e.ctrlKey && e.target.tagName === 'TEXTAREA' ) {
                // Ctrl＋Enterで改行処理を行う
                const t = e.target;           
                const {selectionStart: start, selectionEnd: end} = t;
                t.value = `${t.value.slice(0, start)}\n${t.value.slice(end)}`;
                t.selectionStart = t.selectionEnd = start + 1;             
                return;
                } else if (e.ctrlKey) {
                return;
                }

                // submitしない
                e.preventDefault();
                //　focus可能な項目が入れ子になっている場合、targetのみで処理する
                e.stopPropagation();

                // tabindex順に移動するためソート
                let sortedList = $(elements).sort((a,b) => {
                if(a.tabIndex && b.tabIndex) {
                    return a.tabIndex - b.tabIndex; 
                } else if(a.tabIndex && !b.tabIndex) {
                    return -1;
                } else if(!a.tabIndex && b.tabIndex) {
                    return 1;
                }
                return 0;
                });

                if (e.target.tabIndex < 0) {
                // tabindexがマイナスの場合、DOM上で次の項目へ移動するためソート前の項目から検索する
                sortedList = elements;
                }

                // 現在の項目位置から、移動先を取得する
                const index = $(sortedList).index(e.target);
                const nextFilter = e.shiftKey ? `:lt(${index}):last` : `:gt(${index}):first`;            
                const nextTarget = $(sortedList).filter(nextFilter);

                // shift + enterでtagindexがマイナスの項目へ移動するのを防ぐ
                if (!nextTarget.length || nextTarget[0].tabIndex < 0) return;

                // フォーカス移動＋文字列選択
                nextTarget.focus();
                if (typeof nextTarget.select === 'function' && nextTarget[0].tagName === 'INPUT') {
                nextTarget.select();
                }
            }
            });
        });

        // F1～F12までのキーを使用不可とする。
        $(window).keydown(function(e)
            {
            var code = e.keyCode;
            if(!isNaN(code) && code >= 112 && code <= 123)
            {
                return false;   
            }
        });
        
        $(window).keydown(function(e)
            {
            var code = e.keyCode;
            if(!isNaN(code) && code >= 112 && code <= 123)
            {
                if(e.preventDefault){
                    // デフォルトの動作を無効化する
                    e.preventDefault();
                    switch (code) {
                        //F1
                        case 112:
                            document.getElementById("F1").click();
                            break;
                        //F2
                        case 113:
                            document.getElementById("F2").click();
                            break;
                        //F3
                        case 114:
                            document.getElementById("F3").click();
                            break;
                        //F4
                        case 115:
                            document.getElementById("F4").click();
                            break;
                        //F5
                        case 116:
                            document.getElementById("F5").click();
                            break;
                        //F6
                        case 117:
                            document.getElementById("F6").click();
                            break;
                        //F7
                        case 118:
                            document.getElementById("F7").click();
                            break;
                        //F8
                        case 119:
                            document.getElementById("F8").click();
                            break;
                        //F9
                        case 120:
                            document.getElementById("F9").click();
                            break;
                        //F10
                        case 121:
                            document.getElementById("F10").click();
                            break;
                        //F11
                        case 122:
                            document.getElementById("F11").click();
                            break;
                        //F12
                        case 123:
                            document.getElementById("F12").click();
                            break;
                        default:
                            break;
                    }
                }else{
                    // デフォルトの動作を無効化する（非標準）
                    e.keyCode = 0;
                    document.getElementById("search").click();
                    return false;
                }
                
                //document.getElementById("seach").click();
                //return true;  
            }
        });

        function check()
            {
                if (event.keyCode = 112)
                {
                    document.getElementById("seach").click();
                }
            }
        </script>
        {{--  2023add  --}}

        @livewireStyles()
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.header')
            @include('layouts.side')

            <!-- Page Content -->
            <main class="max-w-full mx-auto p-2 sm:p-3 lg:p-4 left-40 lg:left-48">
                @if($title ?? null)
                    <h2 class="mb-1">{{ $title }}</h2>
                @endif
                {{ $slot }}
            </main>
        </div>
        @livewireScripts()
    </body>
</html>
