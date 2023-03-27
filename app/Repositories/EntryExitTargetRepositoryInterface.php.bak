<?php

namespace App\Repositories;

use App\Models\EntryExitTarget;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EntryExitTargetRepositoryInterface
{
    /**
     * @param int $id
     * @return EntryExitTarget
     */
    public function get(int $id): EntryExitTarget;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return EntryExitTarget
     */
    public function newEntity(): EntryExitTarget;

    /**
     * @param EntryExitTarget $entity
     * @return bool
     */
    public function save(EntryExitTarget $entity): bool;

    /**
     * @param EntryExitTarget $entity
     * @return bool|null
     */
    public function delete(EntryExitTarget $entity): ?bool;
}
