<?php 

use Illuminate\Database\Eloquent\Model;

/**
 * Class TextTest
 */
class TextTest extends TestCase
{
    /**
     * @test
     * @testdox 0It generates valid attributes
     */
    public function it_generates_valid_attributes(): void
    {
        $this->assertBladeRender('', "@text('description')");
        $this->assertBladeRender('default', "@text('description', 'default')");
    }


    /**
     * @test
     * @testdox It generates valid attributes when the model does not have the attribute
     */
    public function it_generates_valid_attributes_when_the_model_does_not_have_the_attribute(): void
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('description')->willReturn(null);

        $viewData = ['model' => $model->reveal()];
        
        $this->assertBladeRender('', '@form($model) @text("description")', $viewData);
        $this->assertBladeRender('default', '@form($model) @text("description", "default")', $viewData);
        $this->assertBladeRender('', '');
    }

    /**
     * @test
     * @testdox It generates walid attributes when old input exists
     */
    public function it_generates_valid_attributes_when_old_input_exists(): void
    {
        $this->session(['_old_input' => ['description' => 'Description']]);
        $this->assertBladeRender('Description', '@text("description")');
    }

    /**
     * @test
     * @testdox It generates valid attributes when old input and model exists
     */
    public function it_generates_valid_attributes_when_old_input_and_model_exists(): void
    {
        $this->session(['_old_input' => ['description' => 'Description from old input']]);

        $model = $this->prophesize(Model::class);
        $model->getAttribute('description')->willReturn('Description from model');

        $viewData = ['model' => $model->reveal()];
        $this->assertBladeRender('Description from old input', '@form($model) @text("description")', $viewData);
    }

    /**
     * @test
     * @testdox It generates walid attributes when model exists
     */
    public function it_generates_valid_attributes_when_model_exists(): void
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('description')->willReturn('Description');
        
        $viewData = ['model' => $model->reveal()];
        $this->assertBladeRender('Description', '@form($model) @text("description")', $viewData);
    }
}
