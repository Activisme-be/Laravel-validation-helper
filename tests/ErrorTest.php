<?php

/**
 * Class ErrorTest
 */
class ErrorTest extends TestCase
{
    /**
     * @test
     * @testdox Do not display error when there is no errors
     */
    public function do_not_display_error_when_there_is_no_errors(): void
    {
        $this->assertBladeRender('', '@error("field")');
    }

    /**
     * @test
     * @testdox Display error
     */
    public function display_error(): void
    {
        $this->withError('field', 'Error Message');
        $this->assertBladeRender('<div class="invalid-feedback">Error Message</div>', '@error("field")');
    }

    /**
     * @test
     * @testdox Display error with custom template
     */
    public function display_error_with_custom_template(): void
    {
        $this->withError('field_name', 'Error Message');
        
        $this->assertBladeRender('has-error', "@error('field_name', 'has-error')");
        $this->assertBladeRender('<span>Error Message</span>', "@error('field_name', '<span>:message</span>')");
    }

    /**
     * @test
     * @testdox Display error with custom template defined in config
     */
    public function display_error_with_custom_template_defined_in_config(): void
    {
        $originalConfig = config('form-helpers.error_template');
        config(['form-helpers.error_template' => '<error>:message</error>']);

        $this->withError('field_name', 'Error Message');
        $this->assertBladeRender('<error>Error Message</error>', "@error('field_name')");

        config(['form-helpers.error_template' => $originalConfig]);
    }

    /**
     * @test
     * @testdox Escape error
     */
    public function escape_error(): void
    {
        $this->withError('field_name', '<html>');
        $this->assertBladeRender('<div class="invalid-feedback">&lt;html&gt;</div>', '@error("field_name")');
    }
}
