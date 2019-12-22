<?php

use Illuminate\Database\Eloquent\Model;

/**
 * Class CheckboxTest
 */
class CheckboxTest extends TestCase
{
    /** @testdox It generates valid attributes */
    public function test_it_generates_valid_attributes(): void
    {
        $this->assertBladeRender('name="accept" value="1"', "@checkbox('accept')");
        $this->assertBladeRender('name="accept" value="ok"', "@checkbox('accept', 'ok')");
        $this->assertBladeRender('name="accept" value="1" checked', "@checkbox('accept', 1, true)");
    }

    /** @testdox It generates valid attributes when the model does not have the attribute */
    public function test_it_generates_valid_attributes_when_the_model_does_not_have_the_attribute(): void
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('accept')->willReturn(null);

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('name="accept" value="1"', '@form($model) @checkbox("accept")', $viewData);
        $this->assertBladeRender('name="accept" value="ok"', '@form($model) @checkbox("accept", "ok")', $viewData);
    }

    /** @testdox It generates valid attributes when old input exists. */
    public function test_it_generates_valid_attributes_when_old_input_exists(): void
    {
        $this->session(['_old_input' => ['accept' => '1', 'accept2' => 'not_ok']]);

        $this->assertBladeRender('name="accept" value="1" checked', "@checkbox('accept')");
        $this->assertBladeRender('name="accept2" value="ok"', "@checkbox('accept2', 'ok')");
    }

    /** @testdox It generates valid attributes when old input and model exists. */
    public function test_it_generates_valid_attributes_when_old_input_and_model_exists(): void
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('accept')->willReturn(null);

        $this->session(['_old_input' => ['accept' => '1']]);

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('name="accept" value="1" checked', '@form($model) @checkbox("accept")', $viewData);
    }

    /** @testdox It generates valid attributes when model exists. */
    public function test_it_generates_valid_attributes_when_model_exists(): void
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('accept')->willReturn(1);
        $model->getAttribute('accept2')->willReturn(null);

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('name="accept" value="1" checked', '@form($model) @checkbox("accept")', $viewData);
        $this->assertBladeRender('name="accept2" value="1"', '@form($model) @checkbox("accept2")', $viewData);
    }
}
