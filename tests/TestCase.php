<?php

use ActivismeBE\FormHelper\FormServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        app('Activisme_BE')->model(null);   // Unbind the model before each test
        $this->session(['errors' => null]);         // Remove errors before each test
    }

    public function createApplication(): Application
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        $app->register(FormServiceProvider::class);

        return $app;
    }

    protected function assertBladeRender(string $render, string $string, array $data = []): self
    {
        $path = __DIR__. '/views/test.blade.php';
        File::put($path, $string);
        $this->assertEquals($render, view()->file($path, $data)->render());

        return $this;
    }

    protected function withError(string $field, string $message): self
    {
        $errors = new ViewErrorBag();
        $errors->put('default', new MessageBag([$field => [$message]]));

        $this->session(['errors' => $errors]);

        return $this;
    }
}
