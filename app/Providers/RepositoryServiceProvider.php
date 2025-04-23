<?php

namespace App\Providers;

use App\Interfaces\Api\Job\JobRepositoryInterface;
use App\Repository\Api\Job\JobRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->bindRepositories();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected function bindRepositories(): void
    {
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
    }
}
