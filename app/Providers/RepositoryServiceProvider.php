<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TeamRepository;
use App\Repositories\DeploymentRepository;
use App\Repositories\EbEnvironmentRepository;
use App\Repositories\EbEnvironmentStatusRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application repositires.
     */
    public function boot()
    {
        // Nothing to boot
    }
    /**
     * Register the application repositories.
     */
    public function register()
    {
        $this->app->bind(TeamRepository::class, TeamRepository::class);
        $this->app->bind(DeploymentRepository::class, DeploymentRepository::class);
        $this->app->bind(EbEnvironmentRepository::class, EbEnvironmentRepository::class);
        $this->app->bind(EbEnvironmentStatusRepository::class, EbEnvironmentStatusRepository::class);
    }   
    
}