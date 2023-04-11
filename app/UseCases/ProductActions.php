<?php

namespace App\UseCases;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\StockTakingRequest;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\StockRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Enums\TaxRateType;
use App\Enums\TaxableMethodType;

class ProductActions
{
    private ProductRepositoryInterface $productRepository;
    private StockRepositoryInterface $stockRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        StockRepositoryInterface $stockRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->stockRepository = $stockRepository;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function get(int $id): Product
    {
        return $this->productRepository->get($id);
    }

    public function getKariProduct(): ?Product
    {
        return $this->productRepository->newKariEntity();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return $this->productRepository->all_this_stock();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function findByName(string $name): LengthAwarePaginator
    {
        return $this->reportRepository->findByName($name);
    }


    /**
     * @param string $code
     * @return Product|null
     */
    public function findByCode(string $code): ?Product
    {
        return $this->productRepository->findByCode($code);
    }

    /**
     * @param ProductRequest $post
     */
    public function create(ProductRequest $post)
    {
        $entity = $this->productRepository->newEntity();
        $this->update($entity, $post);
    }

    /**
     * @param Product $entity
     * @param ProductRequest $post
     * @return bool
     */
    public function update(Product $entity, ProductRequest $post): bool
    {
        // 値が変わっている場合だけ更新し、saveを実行
        $entity->code = $post->code;
        $entity->name = $post->name;
        $entity->name_read = $post->name_read;
        $entity->artist = $post->artist;
        $entity->artist_read = $post->artist_read;
        $entity->category_id = $post->category_id;
        $entity->genre_id = $post->genre_id;
        if ($post->maker_id === null){
            $post->maker_id = 6;
        }
        //dd($post->maker_id);
        $entity->maker_id = $post->maker_id;
        $entity->note1 = $post->note1;
        $entity->note2 = $post->note2;
        $entity->note3 = $post->note3;
        $this->productRepository->save($entity);
        // productから自店のstockを取得
        $stock = $this->stockRepository->getOne($entity->id);
        if (is_null($stock)) {
            $stock = $this->stockRepository->newEntity();
            $stock->product_id = $entity->id;
            $stock->shop_id = Auth::user()->shop->id;
        }
        // stockの情報を登録
        $stock->sell_price = $post->sell_price;
        $stock->sell_tax_rate_type_id = $post->sell_tax_rate_type_id;
        $stock->sell_taxable_method_type_id = $post->sell_taxable_method_type_id;
        $stock->stocking_price = $post->stocking_price;
        $stock->stocking_tax_rate_type_id = $post->stocking_tax_rate_type_id;
        $stock->stocking_taxable_method_type_id = $post->stocking_taxable_method_type_id;
        $this->stockRepository->save($stock);
        return true;
    }

    /**
     * @param Product $entity
     * @param ProductRequest $post
     * @return bool
     */
    public function update_stock_taking(Product $entity, StockTakingRequest $post): bool
    {
        $stock = $this->stockRepository->getOne($entity->id);
        if (is_null($stock)) {
            return true;
        }else{
            $stock->rack_code = $post->rack_code;
            $stock->stocktaking_quantity = $post->stocktaking_quantity;
            $stock->is_stocktaking = 1;
            $this->stockRepository->save($stock);
            return true;
        }

    }

    public function delete(Product $entity): ?bool
    {
        return $this->productRepository->delete($entity);
    }
}
