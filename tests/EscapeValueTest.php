<?php

/**
 * Class EscapeValueTest
 */
class EscapeValueTest extends TestCase
{
    /** @testdox Escape value for an input field */
    public function test_escape_value_for_an_input_field(): void
    {
        $this->assertBladeRender('name="name" value="&lt;"', "@input('name', '<')");
    }

    /** @testdox Escape value for a textarea */
    public function test_escape_value_for_a_textarea(): void
    {
        $this->assertBladeRender('&lt;html&gt;', "@text('name', '<html>')");
    }

    /** @testdox Escape value for a checkbox */
    public function test_escape_value_for_a_checkbox(): void
    {
        $this->assertBladeRender('name="name" value="&lt;"', "@checkbox('name', '<')");
    }

    /** @testdox Escape value for a radio button */
    public function test_escape_value_for_a_radio_button(): void
    {
        $this->assertBladeRender('name="name" value="&lt;"', "@radio('name', '<')");
    }

    /** @testdox Escape value for an option */
    public function test_escape_value_for_an_option(): void
    {
        $this->assertBladeRender('<option value="&lt;">Text</option>', '@options($options, "name")', [
            'options' => ['<' => 'Text']
        ]);
    }
}
