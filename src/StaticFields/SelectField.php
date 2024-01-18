<?php

namespace WCProductMetaFramework;

abstract class SelectField extends BaseField
{
    protected $options = array();

    protected function getOptions() {
        return $this->options;
    }

    protected function drawMetaBox() : void
    {
        error_log(sprintf('SelectField(%s)::outputField()', $this->getId()));
        $field_data = array(
            'id'            => $this->getId(),
            'label'         => $this->getLabel(),
            'description'   => $this->getDescription(),
            'desc_tip'      => $this->description_as_tip,
            'options'       => $this->getOptions(),
            'class'         => $this->class,
            'wrapper_class' => $this->wrapper_class,
            'style'         => $this->style,
        );
        woocommerce_wp_select($field_data);
    }

    protected function processSaveValue($value) : mixed
    {
        return $value;
    }
}
