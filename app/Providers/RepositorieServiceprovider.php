<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
class RepositorieServiceprovider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            BaseRepositoryInterface::class,
            BaseRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
