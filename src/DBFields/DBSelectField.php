<?php

namespace WCProductMetaFramework;

abstract class DBSelectField extends SelectField
{
    protected string $dblist_class = '';
    protected mixed $dblist = null;

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
            $this->options = $this->getDBList()->getItems();
        }
        return $this->options;
    }
}
