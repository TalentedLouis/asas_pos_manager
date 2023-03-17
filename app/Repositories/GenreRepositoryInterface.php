<?php

namespace App\Repositories;

use App\Models\Genre;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface GenreRepositoryInterface
{
    /**
     * @param int $id
     * @return Genre
     */
    public function get(int $id): Genre;

    /**
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * @return Genre
     */
    public function newEntity(): Genre;

    /**
     * @param Genre $entity
     * @return bool
     */
    public function save(Genre $entity): bool;

    /**
     * @param Genre $entity
     * @return bool|null
     */
    public function delete(Genre $entity): ?bool;

    /**
     * @return Collection
     */
    public function getSelect(): Collection;
}
