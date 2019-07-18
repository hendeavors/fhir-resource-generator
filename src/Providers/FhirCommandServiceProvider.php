<?php

namespace Endeavors\Fhir;

use Illuminate\Support\ServiceProvider;
use Endeavors\Fhir\Console\ResourceGenerationCommand;

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
            ]);
        }
    }
}
