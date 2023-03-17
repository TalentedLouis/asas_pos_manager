<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class ProductService
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function getByCode($code): ?Product
    {
        return $this->repository->findByCode($code);
    }
}
