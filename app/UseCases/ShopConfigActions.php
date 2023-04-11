<?php

namespace App\UseCases;

use App\Http\Requests\DailyRenewalRequest;
use App\Http\Requests\ShopConfigRequest;
use App\Models\ShopConfig;
use App\Repositories\ShopConfigRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ShopConfigActions
{
    private ShopConfigRepositoryInterface $repository;

    public function __construct(ShopConfigRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function get(): ?ShopConfig
    {
        return $this->repository->getOne();
    }

    public function find(int $id): ?ShopConfig
    {
        return $this->repository->get($id);
    }

    public function get_trans_date(): ?String
    {
        $target_repository = $this->repository->getOne();
        $date = $target_repository->trans_date;
        return $date;
    }

    public function get_renewal_date(): ?String
    {
        $target_repository = $this->repository->getOne();
        $date = $target_repository->trans_date;
        $date = date("Y-m-d",strtotime($date."+1 day"));
        return $date;
    }

    public function daily_renewal(ShopConfig $entity, DailyRenewalRequest $post)
    {
        $entity->shop_id=Auth::user()->shop->id;
        $entity->trans_date=$post->renewal_date;
        return $this->repository->save($entity);
    }

    public function create(ShopConfigRequest $post)
    {
        $entity = $this->repository->newEntity();
        $this->update($entity, $post);
    }

    public function update(ShopConfig $entity, ShopConfigRequest $post)
    {
        $entity->shop_id=Auth::user()->shop->id;
        $entity->delay_minutes=$post->delay_minutes;
        $entity->exit_reserve_minutes=$post->exit_reserve_minutes;
        $entity->slip_number_sequence=$post->slip_number_sequence;
        $entity->trans_date=$post->trans_date;
        return $this->repository->save($entity);
    }

    public function delete(ShopConfig $entity)
    {
        return $this->repository->delete($entity);
    }
}
