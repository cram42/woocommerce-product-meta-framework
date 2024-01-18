<?php

namespace WCProductMetaFramework;

abstract class TextField extends BaseField
{
    protected string $data_type = '';
    protected string $placeholder = '';

    protected function drawMetaBox() : void
    {
        error_log(sprintf('TextField(%s)::outputField()', $this->getId()));
        $field_data = array(
            'id'            => $this->getId(),
            'label'         => $this->getLabel(),
            'description'   => $this->getDescription(),
            'desc_tip'      => $this->description_as_tip,
            'data_type'     => $this->data_type,
            'placeholder'   => $this->placeholder,
            'class'         => $this->class,
            'wrapper_class' => $this->wrapper_class,
            'style'         => $this->style,
        );
        woocommerce_wp_text_input($field_data);
    }

    protected function processSaveValue($value) : mixed
    {
        return esc_attr($value);
    }
}
