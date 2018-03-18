<?php

/**
 * Class EscapeValueTest
 */
class EscapeValueTest extends TestCase
{
    /**
     * @test
     * @testdox Excape value for an input field
     */
    public function escape_value_for_an_input_field(): void
    {
        $this->assertBladeRender('name="name" value="&lt;"', "@input('name', '<')");
    }

    /**
     * @test
     * @testdox Excape value for a textarea
     */
    public function escape_value_for_a_textarea(): void
    {
        $this->assertBladeRender('&lt;html&gt;', "@text('name', '<html>')");
    }

    /**
     * @test
     * @testdox Excape value for a checkbox
     */
    public function escape_value_for_a_checkbox(): void
    {
        $this->assertBladeRender('name="name" value="&lt;"', "@checkbox('name', '<')");
    }

    /**
     * @test
     * @testdox Escape value for a radio button
     */
    public function escape_value_for_a_radio_button(): void
    {
        $this->assertBladeRender('name="name" value="&lt;"', "@radio('name', '<')");
    }

    /**
     * @test
     * @testdox Escape valie for an option
     */
    public function escape_value_for_an_option(): void
    {
        $this->assertBladeRender('<option value="&lt;">Text</option>', '@options($options, "name")', [
            'options' => ['<' => 'Text']
        ]);
    }
}
