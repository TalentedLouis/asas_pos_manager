<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductRepository implements ProductRepositoryInterface
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

    public function findByName(string $name): LengthAwarePaginator
    {
        //return Product::where('name', 'LIKE' ,'%'.$name.'%')->paginate(15);
        
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
