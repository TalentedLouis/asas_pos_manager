<?php

namespace App\Repositories;

use App\Models\SupplierTarget;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SupplierTargetRepository implements SupplierTargetRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): ?SupplierTarget
    {
        return SupplierTarget::find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return DB::table('supplier_targets')->whereNull('deleted_at')->orderBy('id')->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): SupplierTarget
    {
        return new SupplierTarget();
    }

    /**
     * @inheritDoc
     */
    public function save(SupplierTarget $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(SupplierTarget $entity): ?bool
    {
        return $entity->delete();
    }

}
