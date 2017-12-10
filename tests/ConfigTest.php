<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

/**
 * Class ConfigTest
 */
class ConfigTest extends TestCase
{
    /**
     * @test 
     */
    public function config_file_is_published()
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