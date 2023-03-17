<?php

namespace App\Repositories;

use App\Models\ConfigRegi;
use Illuminate\Support\Collection;

interface ConfigRegiRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @return ConfigRegi|null
     */
    public function getOne(): ?ConfigRegi;

    /**
     * @return ConfigRegi
     */
    public function newEntity(): ConfigRegi;

    /**
     * @param ConfigRegi $configRegi
     * @return bool
     */
    public function save(ConfigRegi $configRegi): bool;
}
