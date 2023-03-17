<?php

namespace App\Repositories;

use App\Models\Maker;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MakerRepository implements MakerRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): Maker
    {
        return DB::table('makers')->whereNull('deleted_at')->find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return DB::table('makers')->whereNull('deleted_at')->orderBy('id')->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): Maker
    {
        return new Maker();
    }

    /**
     * @inheritDoc
     */
    public function save(Maker $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Maker $entity): ?bool
    {
        return $entity->delete();
    }

    public function getSelect(): Collection
    {
        return DB::table('makers')->whereNull('deleted_at')->orderBy('id')->pluck('name', 'id');
    }
}
