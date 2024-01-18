<?php

namespace WCProductMetaFramework;

abstract class CheckboxField extends BaseField
{
    protected string $class = '';
    protected bool $description_as_tip = false;

    protected function getTrueValue() : string {
        return 'yes';
    }

    protected function getFalseValue() : string {
        return 'no';
    }

    protected function drawMetaBox() : void
    {
        error_log(sprintf('CheckboxField(%s)::outputField()', $this->getId()));
        $field_data = array(
            'id'            => $this->getId(),
            'label'         => $this->getLabel(),
            'description'   => $this->getDescription(),
            'desc_tip'      => $this->description_as_tip,
            'cbvalue'       => $this->getTrueValue(),
            'class'         => $this->class,
            'wrapper_class' => $this->wrapper_class,
            'style'         => $this->style,
        );
        woocommerce_wp_checkbox($field_data);
    }

    protected function processSaveValue($value) : mixed
    {
        return ($value === null) ? $this->getFalseValue() : $this->getTrueValue();
    }
}
