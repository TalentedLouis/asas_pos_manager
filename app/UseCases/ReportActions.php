<?php

namespace App\UseCases;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\StockTakingRequest;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ReportRepositoryInterface;
use App\Repositories\StockRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Enums\TaxRateType;
use App\Enums\TaxableMethodType;

class ReportActions
{
    private ProductRepositoryInterface $productRepository;
    private ReportRepositoryInterface $reportRepository;
    private StockRepositoryInterface $stockRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        StockRepositoryInterface $stockRepository,
        ReportRepositoryInterface $reportRepository,
    )
    {
        $this->productRepository = $productRepository;
        $this->stockRepository = $stockRepository;
        $this->reportRepository = $reportRepository;
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
    public function findByName(string $name,int $reportTypeId,string $fromDate,string $toDate,string $shopId): LengthAwarePaginator
    {
        return $this->reportRepository->findByName($name,$reportTypeId,$fromDate,$toDate,$shopId);
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

    
}
