<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TeamRepository;

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
        $this->registerDatabaseConnectionRepository();
    }   
    
    /**
     * registers the database repository for use in the application
     */
    protected function registerDatabaseConnectionRepository() 
    {
        $this->app->bind(TeamRepository::class, TeamRepository::class);
    }
}