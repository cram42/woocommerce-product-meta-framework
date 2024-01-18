<?php

namespace WCProductMetaFramework;

abstract class TextAreaField extends BaseField
{
    protected string $placeholder = '';

    protected function drawMetaBox() : void
    {
        error_log(sprintf('TextAreaField(%s)::outputField()', $this->getId()));
        $field_data = array(
            'id'            => $this->getId(),
            'label'         => $this->getLabel(),
            'description'   => $this->getDescription(),
            'desc_tip'      => $this->description_as_tip,
            'placeholder'   => $this->placeholder,
            'class'         => $this->class,
            'wrapper_class' => $this->wrapper_class,
            'style'         => $this->style,
        );
        woocommerce_wp_textarea_input($field_data);
    }

    protected function processSaveValue($value) : mixed
    {
        return esc_attr($value);
    }
}
