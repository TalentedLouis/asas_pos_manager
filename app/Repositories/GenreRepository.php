<?php

namespace App\Repositories;

use App\Models\Genre;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GenreRepository implements GenreRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): Genre
    {
        return DB::table('genres')->whereNull('deleted_at')->find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return DB::table('genres')->whereNull('deleted_at')->orderBy('id')->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): Genre
    {
        return new Genre();
    }

    /**
     * @inheritDoc
     */
    public function save(Genre $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Genre $entity): ?bool
    {
        return $entity->delete();
    }

    /**
     * @inheritDoc
     */
    public function getSelect(): Collection
    {
        return DB::table('genres')->whereNull('deleted_at')->orderBy('id')->pluck('name', 'id');
    }
}
