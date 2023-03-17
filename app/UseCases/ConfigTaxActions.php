<?php

namespace App\UseCases;

use App\Http\Requests\ConfigTaxRequest;
use App\Models\ConfigTax;
use App\Repositories\ConfigTaxRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ConfigTaxActions
{
    private ConfigTaxRepositoryInterface $repository;

    /**
     * @param ConfigTaxRepositoryInterface $repository
     */
    public function __construct(ConfigTaxRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return ConfigTax
     */
    public function get(int $id): ConfigTax
    {
        return $this->repository->get($id);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return $this->repository->all();
    }

    /**
     * @param $post
     */
    public function create($post)
    {
        $entity = $this->repository->newEntity();
        $this->update($entity, $post);
    }

    /**
     * @param ConfigTax $entity
     * @param ConfigTaxRequest $post
     * @return bool
     */
    public function update(ConfigTax $entity, ConfigTaxRequest $post): bool
    {
        $entity->tax_rate1 = $post->tax_rate1;
        $entity->tax_rate2 = $post->tax_rate2;
        $entity->started_on = $post->started_on;
        return $this->repository->save($entity);
    }

    public function delete(ConfigTax $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
