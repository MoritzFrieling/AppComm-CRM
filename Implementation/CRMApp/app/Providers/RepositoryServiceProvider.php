<?php

namespace App\Providers;

use App\Interfaces\ContactPersonRepositoryInterface;
use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\CustomerSolutionRepositoryInterface;
use App\Interfaces\GitlabProjectRepositoryInterface;
use App\Interfaces\SolutionRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Repositories\ContactPersonRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\CustomerSolutionRepository;
use App\Repositories\GitlabProjectRepository;
use App\Repositories\SolutionRepository;
use App\Repositories\TicketRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(ContactPersonRepositoryInterface::class, ContactPersonRepository::class);
        $this->app->bind(SolutionRepositoryInterface::class, SolutionRepository::class);
        $this->app->bind(CustomerSolutionRepositoryInterface::class, CustomerSolutionRepository::class);
        $this->app->bind(TicketRepositoryInterface::class, TicketRepository::class);
        $this->app->bind(GitlabProjectRepositoryInterface::class, GitlabProjectRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
