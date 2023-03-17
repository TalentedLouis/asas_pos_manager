<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ConfigTax;
use App\Models\Customer;
use App\Models\EntryExitTarget;
use App\Models\Genre;
use App\Models\Maker;
use App\Models\Plan;
use App\Models\Shop;
use App\Models\Staff;
use App\Models\SupplierTarget;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        Shop::factory(3)->create();
//        User::factory(5)->create();
        //        SupplierTarget::factory(25)->create();
        //        Category::factory(30)->create();
        //        Genre::factory(30)->create();
        //        Maker::factory(30)->create();
        //        Customer::factory(2)->create();
        //        Maker::factory(30)->create();
        //        Customer::factory(2)->create();
        //        EntryExitTarget::factory(10)->create();
        // ConfigTax::factory(1)->create();
//         Plan::factory(5)->create();
        // Type::factory(3)->create();
        Staff::factory(5)->create();
    }
}
