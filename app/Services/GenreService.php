<?php

namespace App\Services;

use App\Repositories\GenreRepositoryInterface;

class GenreService
{
    private GenreRepositoryInterface $repository;

    public function __construct(GenreRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function getSelect() {
        return $this->repository->getSelect();
    }
}
