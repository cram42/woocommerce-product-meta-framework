<?php

namespace WCProductMetaFramework;

abstract class DBSelectField extends SelectField
{
    protected mixed $dblist = null;

    protected string $dblist_class = '';
    protected string $order_by = 'id';
    protected bool $order_desc = false;
    protected bool $allow_blank = true;

    protected function getDBList()
    {
        if ($this->dblist == null) {
            if (empty($this->dblist_class)) {
                throw new \Exception("dblist_class not provided.");
            }
            $this->dblist = $this->dblist_class::getInstance();
        }
        return $this->dblist;
    }

    protected function getOptions() {
        if (count($this->options) == 0) {
            if ($this->allow_blank) {
                $this->options[''] = '';
            }
            $items = $this->getDBList()->getItems($this->order_by, $this->order_desc);
            foreach ($items as $key => $value) {
                $this->options[$key] = $value;
            }
        }
        return $this->options;
    }
}
