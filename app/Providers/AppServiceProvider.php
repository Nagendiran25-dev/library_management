<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\BookRepository;
use App\Repositories\Contracts\BookBorrowedRepositoryInterface;
use App\Repositories\BookBorrowedRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(BookBorrowedRepositoryInterface::class, BookBorrowedRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
