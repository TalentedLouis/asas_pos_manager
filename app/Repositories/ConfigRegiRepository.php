<?php

namespace App\Repositories;

use App\Models\ConfigRegi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ConfigRegiRepository implements ConfigRegiRepositoryInterface
{
    public function all(): Collection
    {
        return ConfigRegi::all();
    }

    /**
     * @return ConfigRegi|null
     */
    public function getOne(): ?ConfigRegi
    {
        $result = ConfigRegi::select()->orderBy('id')->limit(1)->get();
        if (count($result) == 0) {
            return null;
        }
        return $result[0];
    }

    public function newEntity(): ConfigRegi
    {
        return new ConfigRegi();
    }

    public function save(ConfigRegi $configRegi): bool
    {
        return $configRegi->save();
    }
}
