<?php

use Illuminate\Database\Eloquent\Model;

/**
 * Class ValueTest
 */
class ValueTest extends TestCase
{
    /** @testdox Value method returns session empty values */
    public function test_value_method_returns_session_empty_values(): void
    {
        $form = app('Activisme_BE');
        session()->flashInput(['field' => '']);

        $this->assertEquals('', $form->value('field'));
    }

    /** @testdox Value method returns model empty values */
    public function test_value_method_returns_model_empty_values(): void
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('field')->willReturn('');

        $form = app('Activisme_BE');
        $form->model($model->reveal());

        $this->assertEquals('', $form->value('field'));
    }

    /** @testdox Value method returns default value */
    public function test_value_method_returns_default_value(): void
    {
        $form = app('Activisme_BE');
        $this->assertEquals('default', $form->value('field', 'default'));
    }
}
