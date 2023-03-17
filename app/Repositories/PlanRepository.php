<?php

namespace App\Repositories;

use App\Models\Plan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PlanRepository implements PlanRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): Plan
    {
        return Plan::find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return Plan::orderBy("id")->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): Plan
    {
        return new Plan();
    }

    /**
     * @inheritDoc
     */
    public function save(Plan $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Plan $entity): ?bool
    {
        return $entity->delete();
    }
}
