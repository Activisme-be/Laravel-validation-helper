<?php

namespace ActivismeBE\FormHelper;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\Store;

/**
 * Class Form
 *
 * @package ActivismeBE\FormHelper
 */
class Form
{
    /** @var Model $model */
    protected $model;

    /** @var Store $store*/
    protected $session;

    /**
     * Form constructor.
     *
     * @param  Store $session
     * @return void
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Set the model to use for the current form.
     *
     * @param  Model|null $model Instance of the given model entity.
     * @return void
     */
    public function model(?Model $model = null): void
    {
        $this->model = $model;
    }

    /**
     * Get the text for a textarea field.
     *
     * @param  string       $name       THe name for the textarea
     * @param  mixed|null   $default    The default value for the textarea
     * @return string
     */
    public function text(string $name, $default = null): string
    {
        return e($this->value($name, $default));
    }

    /**
     * Get the attributes for an input field.
     *
     * @param  string       $name       The name for the input.
     * @param  mixed|null   $default    The default value for the input.
     * @return string
     */
    public function input(string $name, $default = null): string
    {
        $value = e($this->value($name, $default));
        $name = e($name);

        return "name=\"$name\" value=\"$value\"";
    }

    /**
     * Get the attributes for a checkbox.
     *
     * @param  string   $name           The name for the checkbox
     * @param  mixed    $inputValue     The value for the given input
     * @param  bool     $checkByDefault Determine iàf the value is checked or unchecked by default.
     * @return string
     */
    public function checkbox(string $name, $inputValue = 1, bool $checkByDefault = false)
    {
        $value = $this->value($name);

        // Define the state for the checkbox, when $value is null then we
        // use the $checkByDefault value directly, otherwise the checkbox will
        // be checked only if the $value is equal to the $inputValue.
        $checked = $value === null ? $checkByDefault : $value == $inputValue;

        $name = e($name);
        $inputValue = e($inputValue);
        $checked = $checked ? ' checked' : '';

        return "name=\"$name\" value=\"$inputValue\"$checked";
    }

    /**
     * Get the attributes for a radio.
     *
     * @param  string $name             The name for the radio box.
     * @param  mixed  $inputValue       The value for the input.
     * @param  bool   $checkByDefault   Determine if the value is checked or unchecked by default.
     * @return string
     */
    public function radio(string $name, $inputValue = 1, bool $checkByDefault = false)
    {
        return $this->checkbox($name, $inputValue, $checkByDefault);
    }

    /**
     * Get the options for a select.
     *
     * @param  array        $options     The array with data for the options.
     * @param  string       $name        The name for the option attribute.
     * @param  mixed|null   $default     The default value for the options.
     * @param  string|null  $placeholder The placeholder data for the option attribute.
     * @return string
     */
    public function options(array $options, string $name, $default = null, ?string $placeholder = null): string
    {
        $tags = [];
        // Prepend the placeholder to the options list if needed.

        if ($placeholder) {
            $tags[] = '<option value="" selected disabled>'.e($placeholder).'</option>';
        }

        $value = $this->value($name, $default);

        // Cast $default and $value to an array in order to support selects with
        // multiple options selected.
        if (! is_array($value)) {
            $value = [$value];
        }

        foreach ($options as $key => $text) {
            $selected = in_array($key, $value, true) ? ' selected' : '';
            $key = e($key);
            $text = e($text);
            $tags[] = "<option value=\"$key\"$selected>$text</option>";
        }

        return implode($tags);
    }

    /**
     * Get the error message if exists.
     *
     * @param  string      $name     The name for the input field.
     * @param  string|null $template The template code for the error template.
     * @return string|null
     */
    public function error(string $name, ?string $template = null)
    {
        $errors = $this->session->get('errors');

        // Default template is bootstrap friendly.
        if ($template === null) {
            $template = config('form-helpers.error_template');
        }

        if ($errors && $errors->has($name)) {
            return str_replace(':message', e($errors->first($name)), $template);
        }
    }

    /**
     * Get the value to use in an input field.
     *
     * @param  string     $name    The name for the name attribute.
     * @param  mixed|null $default The default input for the name attribute
     * @return mixed|null
     */
    public function value(string $name, $default = null)
    {
        if (($value = $this->valueFromOld($name)) !== null) {
            return $value;
        }

        if (($value = $this->valueFromModel($name)) !== null) {
            return $value;
        }

        return $default;
    }

    /**
     * Get the value from old input.
     *
     * @param  string $name The name for the old input.
     * @return mixed|null
     */
    protected function valueFromOld(string $name)
    {
        return $this->session->getOldInput($name);
    }

    /**
     * Get the value from the model.
     *
     * @param  string $name The name for the model binding.
     * @return mixed|null
     */
    protected function valueFromModel(string $name)
    {
        if (! $this->model) {
            return null;
        }

        return $this->model->getAttribute($name);
    }
}
