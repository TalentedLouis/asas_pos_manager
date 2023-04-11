<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ReportRepository implements ReportRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * @inheritDoc
     */
    public function newKariEntity(): ?Product
    {
        $entity = new Product();
        $entity -> id = '';
        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function findByCode(string $code): ?Product
    {
        $result = Product::where('code', $code)->get();
        if (count($result) == 0) {
            return null;
        }
        return $result[0];
    }

    public function findByName(string $name,int $reportTypeId,string $fromDate,string $toDate,string $shopId): LengthAwarePaginator
    {
        //return Product::where('name', 'LIKE' ,'%'.$name.'%')->paginate(15);
        $user_code = Auth()->id();
        if (Schema::hasTable('note'.$user_code)) {
            DB::statement("drop table note".$user_code.";");
        }
        //対象テーブルを作成する。
        DB::statement("create table note".$user_code."
                            (category_code int,
                            category_name varchar(255),
                            sale_quantity int,
                            sale_money int,
                            sale_per int,
                            exit_stock_quantity int,
                            exit_stock_money int,
                            purchase_quantity int,
                            purchase_money int,
                            entry_stock_quantity int,
                            entry_stock_money int    
                            );");
        //対象テーブルの文字コードを変更する。⇒エラーになるため
        DB::statement("
                            ALTER TABLE note".$user_code."
                            CONVERT TO CHARACTER SET utf8mb4 
                            COLLATE utf8mb4_unicode_ci
                        ;");
        //対象テーブルに売上データをINSERTする。
        DB::statement("INSERT INTO note".$user_code."
                            (category_code,
                             category_name,
                             sale_quantity,
                             sale_money)
                             select category.code,
                                    category.name,
                                    sum(line.quantity),
                                    sum(line.subtotal_tax_included)
                            from transaction_lines as line 
                               inner join categories as category 
                            on line.category_id = category.id
                            where line.transaction_type_id = 1
                              and line.transacted_on >= '".$fromDate."'
                              and line.transacted_on <= '".$toDate."'
                              and line.shop_id = '".$shopId."'
                              and line.deleted_at is null
                            group by category.code,category.name;");
        
        /*
        DB::statement("INSERT INTO note".$user_code."
                            (category_code,
                             category_name)
                             value(2,'test2')");             
        */
        $query = DB::select("select * from note".$user_code.";");
        //return $query->paginate(15);
        
        $query = Product::query();
        $query->select('products.id','code','name','artist',
                     'category_id','genre_id','maker_id','this_stock_quantity',
                     'sell_price','stocking_price')
              ->leftjoin('stocks','stocks.product_id','=','products.id')
              //->where('stocks.shop_id',Auth::user()->shop->id)
              ->where('products.name', 'LIKE' ,'%'.$name.'%')
              ->with(['category','genre']);
        return $query->orderBy("products.name")
              ->paginate(15);
        
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return Product::orderBy('id')->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function all_this_stock(): LengthAwarePaginator
    {
        
        $query = Product::query();
        $query->select('products.id','code','name','artist',
                     'category_id','genre_id','maker_id','this_stock_quantity',
                     'sell_price','stocking_price')
              ->leftjoin('stocks','stocks.product_id','=','products.id')
              ->where('stocks.shop_id',Auth::user()->shop->id)
              ->with(['category','genre']);
        return $query->orderBy("products.id")
              ->paginate(15);

        return Product::orderBy('id')->paginate(15);

        return DB::table('products')
                ->paginate(15);
        /*return DB::table('products')
                ->leftjoin('stocks,products.id','=','stocks.product_id')
                ->where('stocks.shop_id',Auth::user()->shop->id)
                ->paginate(15);
    */
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): Product
    {
        return new Product();
    }

    /**
     * @inheritDoc
     */
    public function save(Product $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Product $entity): ?bool
    {
        return $entity->delete();
    }

}
