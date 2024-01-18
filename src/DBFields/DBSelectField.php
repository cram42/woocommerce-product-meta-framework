<?php

namespace WCProductMetaFramework;

abstract class DBSelectField extends SelectField
{
    protected object $db_list;

    protected function getOptions() {
        if (count($this->options) == 0) {
            $this->options = $this->db_list->getItems();
        }
        return $this->options;
    }
}
