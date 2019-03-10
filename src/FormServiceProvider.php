<?php

namespace ActivismeBE\FormHelper;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Class FormServiceProvider
 *
 * @package ActivismeBE\FormHelper
 */
class FormServiceProvider extends ServiceProvider
{
    /**
     * Get configuration file path.
     *
     * @return string
     */
    protected function configFile(): string
    {
        return __DIR__ . '/config/form-helpers.php';
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([$this->configFile() => config_path('form-helpers.php')]);
        $this->registerBladeDirectives();
    }

    /**
     * Register the service provider
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfig();
        $this->registerBindings();
    }

    /**
     * Merge package configuration file with the application's copy.
     *
     * @return void
     */
    protected function mergeConfig(): void
    {
        $this->mergeConfigFrom($this->configFile(), 'form-helpers');
    }

    /**
     * Register bindings.
     *
     * @return void
     */
    protected function registerBindings(): void
    {
        $this->app->singleton('Activisme_BE', function (): Form {
            return $this->app->make(Form::class);
        });
    }


    /**
     * Register blade directives.
     *
     * @return void
     */
    protected function registerBladeDirectives(): void
    {
        Blade::directive('form', function ($expression): string {
            $expression = $this->addParenthesis($expression);
            return "<?php app('Activisme_BE')->model{$expression}; ?>";
        });

        Blade::directive('input', function ($expression): string {
            $expression = $this->addParenthesis($expression);
            return "<?php echo app('Activisme_BE')->input{$expression}; ?>";
        });

        Blade::directive('text', function ($expression): string {
            $expression = $this->addParenthesis($expression);
            return "<?php echo app('Activisme_BE')->text{$expression}; ?>";
        });

        Blade::directive('checkbox', function ($expression): string {
            $expression = $this->addParenthesis($expression);
            return "<?php echo app('Activisme_BE')->checkbox{$expression}; ?>";
        });

        Blade::directive('radio', function ($expression): string {
            $expression = $this->addParenthesis($expression);
            return "<?php echo app('Activisme_BE')->radio{$expression}; ?>";
        });

        Blade::directive('options', function ($expression): string {
            $expression = $this->addParenthesis($expression);
            return "<?php echo app('Activisme_BE')->options{$expression}; ?>";
        });

        Blade::directive('error', function ($expression): string {
            $expression = $this->addParenthesis($expression);
            return "<?php echo app('Activisme_BE')->error{$expression}; ?>";
        });
    }

    /**
     * Add parenthesis to the expression in order to support Laravel 5.2 and 5.3
     *
     * @param  string $expressions
     * @return string
     */
    protected function addParenthesis(string $expression): string
    {
        return starts_with($expression, '(') ? $expression : "($expression)";
    }
}
