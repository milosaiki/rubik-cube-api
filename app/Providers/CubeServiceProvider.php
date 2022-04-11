<?php

namespace App\Providers;

use App\Repository\CubeRepositoryInterface;
use App\Services\CubeService;
use App\Services\CubeServiceInterface;
use App\Services\HorizontalRotationService;
use App\Services\RotationService;
use App\Services\RotationServiceInterface;
use App\Services\VerticalRotationService;
use Illuminate\Support\ServiceProvider;

class CubeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(HorizontalRotationService ::class);
        $this->app->singleton(VerticalRotationService::class);
        $this->app->singleton(RotationServiceInterface::class, function() {
            return new RotationService(
                $this->app->get(HorizontalRotationService::class),
                $this->app->get(VerticalRotationService::class)
            );
        });

        $this->app->singleton(CubeServiceInterface::class, function () {
            return new CubeService(
                $this->app->get(CubeRepositoryInterface::class),
                $this->app->get(RotationServiceInterface::class)
            );
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
