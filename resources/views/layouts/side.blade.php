<div id="side_menu" class="w-40 lg:w-48 bg-gray-600">
    <div class="">
        <div class="tab w-full overflow-hidden shadow-md">
            <input class="absolute opacity-0" id="tab1" type="checkbox" name="tabs" checked>
            <label class="block p-3 text-gray-100 cursor-pointer flex justify-between" for="tab1">
                通常業務
                <a class="up-icon w-4 h-4 mt-1">
                <a class="down-icon w-4 h-4 mt-1">
            </label>
            <div class="tab-content overflow-hidden">
                <a class="block p-3" href="">
                    入室管理</a>
                <a class="block p-3" href="{{ route('sale.create') }}">
                    売上処理</a>
                <a class="block p-3" href="{{ route('purchase.create') }}">
                    仕入処理</a>
                <a class="block p-3" href="{{ route('entry_stock.create') }}">
                    入庫処理</a>
                <a class="block p-3" href="{{ route('exit_stock.create') }}">
                    出庫処理</a>
                <a class="block p-3" href="">
                    出金処理</a>
                <a class="block p-3" href="">
                    入金処理</a>
                <a class="block p-3" href="">
                    日次更新</a>
            </div>
        </div>
        <div class="tab w-full overflow-hidden shadow-md">
            <input class="absolute opacity-0" id="tab3" type="checkbox" name="tabs" checked>
            <label class="block p-3 text-gray-100 cursor-pointer flex justify-between" for="tab3">
                共通マスター
                <a class="up-icon w-4 h-4 mt-1">
                <a class="down-icon w-4 h-4 mt-1">
            </label>
            <div class="tab-content overflow-hidden">
                <a class="block p-3" href="{{ route('product.index') }}">
                    商品</a>
                <a class="block p-3" href="{{ route('customer.index') }}">
                    顧客</a>
                <a class="block p-3" href="{{ route('category.index') }}">
                    カテゴリー</a>
                <a class="block p-3" href="{{ route('genre.index') }}">
                    ジャンル</a>
                <a class="block p-3" href="{{ route('supplier_target.index') }}">
                    仕入先</a>
                <a class="block p-3" href="{{ route('entry_exit_target.index') }}">
                    入出庫先</a>
                <a class="block p-3" href="{{ route('maker.index') }}">
                    メーカー</a>
                <a class="block p-3" href="{{ route('type.index') }}">
                    部屋タイプ</a>
                <a class="block p-3" href="{{ route('plan.index') }}">
                    利用プラン</a>
            </div>
        </div>
        <div class="tab w-full overflow-hidden shadow-md">
            <input class="absolute opacity-0" id="tab2" type="checkbox" name="tabs" >
            <label class="block p-3 text-gray-100 cursor-pointer flex justify-between" for="tab2">
                店舗マスター
                <a class="up-icon w-4 h-4 mt-1">
                <a class="down-icon w-4 h-4 mt-1">
            </label>
            <div class="tab-content overflow-hidden">
                <a class="block p-3" href="{{ route('room.index') }}">
                    部屋</a>
                <a class="block p-3" href="">
                    料金</a>
                <a class="block p-3" href="{{ route('staff.index') }}">
                    スタッフ</a>
            </div>
        </div>
        <div class="tab w-full overflow-hidden shadow-md">
            <input class="absolute opacity-0" id="tab4" type="checkbox" name="tabs" >
            <label class="block p-3 text-gray-100 cursor-pointer flex justify-between" for="tab4">
                棚卸業務
                <a class="up-icon w-4 h-4 mt-1">
                <a class="down-icon w-4 h-4 mt-1">
            </label>
            <div class="tab-content overflow-hidden">
                <a class="block p-3" href="">
                    棚卸数登録一覧</a>
                <a class="block p-3" href="">
                    棚卸数登録</a>
                <a class="block p-3" href="">
                    棚卸数データ取込</a>
                <a class="block p-3" href="">
                    棚卸確認・更新</a>
            </div>
        </div>
        <div class="tab w-full overflow-hidden shadow-md mb-20">
            <input class="absolute opacity-0" id="tab5" type="checkbox" name="tabs">
            <label class="block p-3 text-gray-100 cursor-pointer flex justify-between" for="tab5">
                設定
                <a class="up-icon w-4 h-4 mt-1">
                <a class="down-icon w-4 h-4 mt-1">
            </label>
            <div class="tab-content overflow-hidden">
                <a class="block p-3" href="{{ route('receipt_config.index') }}">
                    レシート</a>
                <a class="block p-3" href="{{ route('shop.index') }}">
                    店舗</a>
                <a class="block p-3" href="{{ route('shop_config.index') }}">
                    自店情報</a>
                <a class="block p-3" href="{{ route('config_regi.index') }}">
                    レジ設定</a>
                <a class="block p-3" href="{{ route('user.index') }}">
                    ユーザー</a>
                <a class="block p-3" href="{{ route('config_tax.index') }}">
                    消費税率</a>
            </div>
        </div>
    </div>
</div>
