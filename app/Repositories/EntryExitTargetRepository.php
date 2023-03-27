<?php

namespace App\Repositories;

use App\Models\EntryExitTarget;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EntryExitTargetRepository implements EntryExitTargetRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): EntryExitTarget
    {
        return DB::table('entry_exit_targets')->whereNull('deleted_at')->find($id);
    }

    /**
     * @inheritDoc
     */
    public function findByCode(string $code): ?EntryExitTarget
    {
        $result = EntryExitTarget::where('code', $code)->get();
        if (count($result) == 0) {
            return null;
        }
        return $result[0];
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return DB::table('entry_exit_targets')->whereNull('deleted_at')->orderBy('id')->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): EntryExitTarget
    {
        return new EntryExitTarget();
    }

    /**
     * @inheritDoc
     */
    public function save(EntryExitTarget $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(EntryExitTarget $entity): ?bool
    {
        return $entity->delete();
    }

}
