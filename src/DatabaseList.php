<?php

namespace WCProductMetaFramework;

use WPPluginFramework as WPF;

abstract class DatabaseList extends WPF\DBTable
{
    protected $items;

    protected const VALID_ORDER_BY = array('id', 'value', 'label');
    
    protected array $column_definitions = array(
        'value varchar(100) NOT NULL',
        'label varchar(100) NOT NULL',
    );

    protected array $default_records = array();

    public function getId(): string
    {
        if (empty($this->id)) {
            $class_name = get_class($this);
            $class_name = preg_replace('/List$/', '', $class_name);
            $class_name = strtolower(str_replace('\\', '_', $class_name));
            $this->id = $class_name;
        }
        return $this->id;
    }

    public function getItems($order_by = null, $order_desc = false)
    {
        error_log("DatabaseList({$this->getId()})::getItems()");
        
        $order_by = in_array($order_by, static::VALID_ORDER_BY) 
            ? $order_by 
            : static::VALID_ORDER_BY[0];

        if ($this->items == null) {
            $results = $this->readAll();
            $this->items = array();
            foreach ($results as $result) {
                $this->items[$result->value] = $result->label;
            }
        }
        return $this->items;
    }
}