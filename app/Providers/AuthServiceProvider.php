<?php

namespace App\Providers;

use App\Models\Snippet;
use App\Models\Step;
use App\Policies\SnippetPolicy;
use App\Policies\StepPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Snippet::class => SnippetPolicy::class,
        Step::class => StepPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
