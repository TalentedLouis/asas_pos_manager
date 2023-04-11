<?php

namespace App\Services;

use App\Repositories\ConfigRegiRepositoryInterface;

class ConfigRegiService
{
    private ConfigRegiRepositoryInterface $repository;

    public function __construct(ConfigRegiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getProductCodeSuffix(): int
    {
        $entity = $this->repository->getOne();
        return $entity->product_code_suffix;
    }
    public function getProductCodeSequence(): int
    {
        $entity = $this->repository->getOne();
        $entity->product_code_sequence = $entity->product_code_sequence + 1;
        $this->repository->save($entity);
        return $entity->product_code_sequence;
    }

    public function getEntryExitMoneyCode(): string
    {
        $entity = $this->repository->getOne();
        return $entity->entry_exit_money_code;
    }
}
