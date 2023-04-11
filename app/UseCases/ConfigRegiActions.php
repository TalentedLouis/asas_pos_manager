<?php

namespace App\UseCases;

use App\Http\Requests\ConfigRegiRequest;
use App\Models\ConfigRegi;
use App\Repositories\ConfigRegiRepositoryInterface;
use Illuminate\Support\Collection;

class ConfigRegiActions
{
    private ConfigRegiRepositoryInterface $repository;

    /**
     * @param ConfigRegiRepositoryInterface $repository
     */
    public function __construct(ConfigRegiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ConfigRegi|null
     */
    public function getOne(): ?ConfigRegi
    {
        return $this->repository->getOne();
    }

    public function create($post) {
        $entity=$this->repository->newEntity();
        $this->update($entity, $post);
    }

    /**
     * @param ConfigRegi $entity
     * @param ConfigRegiRequest $post
     * @return bool
     */
    public function update(ConfigRegi $entity, ConfigRegiRequest $post): bool
    {
        $entity->product_code_suffix = $post->product_code_suffix;
        $entity->entry_exit_money_code = $post->entry_exit_money_code;
        return $this->repository->save($entity);
    }
}
