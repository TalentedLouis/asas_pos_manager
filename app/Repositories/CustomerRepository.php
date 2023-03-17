<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): Customer
    {
        return DB::table('customers')->whereNull('deleted_at')->find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): LengthAwarePaginator
    {
        return DB::table('customers')->whereNull('deleted_at')->orderBy('id')->paginate(15);
    }

    /**
     * @inheritDoc
     */
    public function newEntity(): Customer
    {
        return new Customer();
    }

    /**
     * @inheritDoc
     */
    public function save(Customer $entity): bool
    {
        return $entity->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Customer $entity): ?bool
    {
        return $entity->delete();
    }

    public function getSelect(): Collection
    {
        return DB::table('customers')->whereNull('deleted_at')->orderBy('id')->pluck('name', 'id');
    }
}
