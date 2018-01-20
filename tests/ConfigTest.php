<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

/**
 * Class ConfigTest
 */
class ConfigTest extends TestCase
{
    /**
     * @test
     * @testdox Config file is published
     */
    public function config_file_is_published(): void
    {
        $configFile = __DIR__.'/../vendor/laravel/laravel/config/form-helpers.php';
        File::delete($configFile);

        $this->assertFileNotExists($configFile);
        Artisan::call('vendor:publish', [
            '--provider' => 'ActivismeBE\FormHelper\FormServiceProvider',
        ]);

        $this->assertFileExists($configFile);
    }
}
