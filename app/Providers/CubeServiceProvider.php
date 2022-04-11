<?php

namespace App\Providers;

use App\Repository\CubeRepositoryInterface;
use App\Services\CubeRotationService;
use App\Services\CubeRotationServiceInterface;
use App\Services\CubeService;
use App\Services\CubeServiceInterface;
use App\Transformers\CubeTransformer;
use App\Transformers\CubeTransformerInterface;
use App\Transformers\HorizontalTransformer;
use App\Transformers\VerticalTransformer;
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
        $this->app->singleton(HorizontalTransformer::class);
        $this->app->singleton(VerticalTransformer::class);
        $this->app->singleton(CubeTransformerInterface::class, function() {
            return new CubeTransformer(
                $this->app->get(HorizontalTransformer::class),
                $this->app->get(VerticalTransformer::class)
            );
        });

        $this->app->singleton(CubeRotationServiceInterface::class, function () {
            return new CubeRotationService($this->app->get(CubeTransformerInterface::class));
        });

        $this->app->singleton(CubeServiceInterface::class, function () {
            return new CubeService(
                $this->app->get(CubeRepositoryInterface::class)
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
