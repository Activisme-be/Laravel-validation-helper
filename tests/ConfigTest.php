<?php

use ActivismeBE\FormHelper\FormServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

/**
 * Class ConfigTest
 */
class ConfigTest extends TestCase
{
    /** @testdox Config file is published. */
    public function test_config_file_is_published(): void
    {
        $configFile = __DIR__.'/../vendor/laravel/laravel/config/form-helpers.php';
        File::delete($configFile);

        $this->assertFileNotExists($configFile);
        Artisan::call('vendor:publish', ['--provider' => FormServiceProvider::class]);

        $this->assertFileExists($configFile);
    }
}
