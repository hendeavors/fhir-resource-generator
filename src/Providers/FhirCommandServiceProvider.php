<?php

namespace Endeavors\Fhir\Providers;

use Illuminate\Support\ServiceProvider;
use Endeavors\Fhir\Console\ResourceGenerationCommand;
use Endeavors\Fhir\Console\ResourceRemovalCommand;

class FhirCommandServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ResourceGenerationCommand::class,
                ResourceRemovalCommand::class
            ]);
        }
    }
}
