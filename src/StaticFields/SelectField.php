<?php

namespace WCProductMetaFramework;

abstract class SelectField extends BaseField
{
    protected $options = array();
    protected bool $allow_blank = true;

    protected function getOptions() {
        if ($this->allow_blank) {
            if (!array_key_exists('', $this->options)) {
                $new_options = array();
                $new_options[''] = '';
                foreach ($this->options as $key => $value) {
                    $new_options[$key] = $value;
                }
                $this->options = $new_options;
            }
        }
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
