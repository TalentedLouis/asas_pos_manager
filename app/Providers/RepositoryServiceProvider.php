<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ConfigRegiRepository;
use App\Repositories\ConfigRegiRepositoryInterface;
use App\Repositories\ConfigTaxRepository;
use App\Repositories\ConfigTaxRepositoryInterface;
use App\Repositories\EntryExitTargetRepository;
use App\Repositories\EntryExitTargetRepositoryInterface;
use App\Repositories\GenreRepository;
use App\Repositories\GenreRepositoryInterface;
use App\Repositories\MakerRepository;
use App\Repositories\MakerRepositoryInterface;
use App\Repositories\CustomerRepository;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\PlanRepository;
use App\Repositories\PlanRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ReceiptConfigRepository;
use App\Repositories\ReceiptConfigRepositoryInterface;
use App\Repositories\RoomRepository;
use App\Repositories\RoomRepositoryInterface;
use App\Repositories\ShopConfigRepository;
use App\Repositories\ShopConfigRepositoryInterface;
use App\Repositories\ShopRepository;
use App\Repositories\ShopRepositoryInterface;
use App\Repositories\StaffRepository;
use App\Repositories\StaffRepositoryInterface;
use App\Repositories\StockRepository;
use App\Repositories\StockRepositoryInterface;
use App\Repositories\SupplierTargetRepository;
use App\Repositories\SupplierTargetRepositoryInterface;
use App\Repositories\TransactionLineRepository;
use App\Repositories\TransactionLineRepositoryInterface;
use App\Repositories\TransactionSlipRepository;
use App\Repositories\TransactionSlipRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\TypeRepository;
use App\Repositories\TypeRepositoryInterface;
use App\Repositories\ReportRepository;
use App\Repositories\ReportRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ShopRepositoryInterface::class, ShopRepository::class);
        $this->app->bind(
            SupplierTargetRepositoryInterface::class,
            SupplierTargetRepository::class
        );
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->bind(
            GenreRepositoryInterface::class,
            GenreRepository::class
        );
        $this->app->bind(
            MakerRepositoryInterface::class,
            MakerRepository::class
        );
        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            ReportRepositoryInterface::class,
            ReportRepository::class
        );
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(
            EntryExitTargetRepositoryInterface::class,
            EntryExitTargetRepository::class
        );
        $this->app->bind(
            ConfigTaxRepositoryInterface::class,
            ConfigTaxRepository::class
        );
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(TypeRepositoryInterface::class, TypeRepository::class);
        $this->app->bind(
            ConfigRegiRepositoryInterface::class,
            ConfigRegiRepository::class
        );
        $this->app->bind(
            ReceiptConfigRepositoryInterface::class,
            ReceiptConfigRepository::class
        );
        $this->app->bind(
            StaffRepositoryInterface::class,
            StaffRepository::class
        );
        $this->app->bind(
            StockRepositoryInterface::class,
            StockRepository::class
        );
        $this->app->bind(RoomRepositoryInterface::class, RoomRepository::class);
        $this->app->bind(TransactionSlipRepositoryInterface::class, TransactionSlipRepository::class);
        $this->app->bind(TransactionLineRepositoryInterface::class, TransactionLineRepository::class);
        $this->app->bind(ShopConfigRepositoryInterface::class, ShopConfigRepository::class);
    }
}
