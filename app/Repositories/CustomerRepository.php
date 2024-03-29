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
    public function findByCode(string $code): ?Customer
    {
        $result = Customer::where('code', $code)->get();
        if (count($result) == 0) {
            return null;
        }
        return $result[0];
    }

    public function findByName(string $name): LengthAwarePaginator
    {
   
        $query = Customer::query();
        $query->select('id','code','name')
              ->where('name', 'LIKE' ,'%'.$name.'%');
        return $query->orderBy("name")
              ->paginate(15);
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
